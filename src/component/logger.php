<?php
namespace YueYue\Component;

class Logger
{/*{{{*/
    const SPLIT_NO      = 0;
    const SPLIT_BY_DAY  = 1;
    const SPLIT_BY_HOUR = 2;

    const DEF_COL_SPR = "\t";

    private static $_log_root = '';
    private static $_log_conf = array
    (/*{{{*/
		'sql' => array(
            'r_path'  => '',
            'split'   => self::SPLIT_BY_DAY,
            'col_spr' => self::DEF_COL_SPR,
        ),
    );/*}}}*/

    public static function init($log_root)
    {/*{{{*/
        self::$_log_root = $log_root;
    }/*}}}*/

    public static function log($key, $data, $write_line_header=true)
    {/*{{{*/
        if(!array_key_exists($key, self::$_log_conf))
        {
            return false;
        }

        $conf = self::$_log_conf[$key];
        $dst  = self::_makeLogFilePath($key, $conf);

        self::_writeLog($dst, $data, $conf['col_spr'], $write_line_header);
    }/*}}}*/


    private static function _makeLogFilePath($key, $conf)
    {/*{{{*/
        $result = self::$_log_root.'/';
        if('' != $conf['r_path'])
        {
            $result.= $conf['r_path'].'/';
        }
        $result.= $key;

        switch($conf['split'])
        {
        case self::SPLIT_BY_DAY:
            $result.= '_'.date('Ymd');
            break;
        case self::SPLIT_BY_HOUR:
            $result.= '_'.date('YmdH');
            break;
        case self::SPLIT_NO:
        default:
            break;
        }

        return $result.'.log';
    }/*}}}*/
    private static function _makeLineHeader()
    {/*{{{*/
        $now = '['.date('Y-m-d H:i:s').']';
        $ip  = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '-';

        return array($now, $ip);
    }/*}}}*/

    private static function _writeLog($dst, $data, $col_spr, $write_line_header)
    {/*{{{*/
        if(!is_array($data))
        {
            $data = array($data);
        }
        if($write_line_header)
        {
            $header = self::_makeLineHeader();
            $data   = array_merge($header, $data);
        }

        $msg = implode($col_spr, $data)."\n";
        error_log($msg, 3, $dst);
    }/*}}}*/
}/*}}}*/
