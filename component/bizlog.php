<?php
/**
* @file bizlog.php
* @brief bizlog
* @author ligang
* @version 1.0
* @date 2014-10-30
 */

namespace YueYue\Component;

class Bizlog
{/*{{{*/
    const SPLIT_NO      = 0;
    const SPLIT_BY_DAY  = 1;
    const SPLIT_BY_HOUR = 2;

    const DEF_COL_SPR = "\t";

    private static $_log_root = '';
    private static $_log_conf_container = array();

    /**
        * @brief must called first
        *
        * @param $log_root
        *
        * @return 
     */
    public static function init($log_root)
    {/*{{{*/
        self::$_log_root = $log_root;
    }/*}}}*/

    /**
        * @brief add log conf
        *
        * @param $key
        * @param $r_path
        * @param $split
        * @param $col_spr
        *
        * @return 
     */
    public static function addLogConf($key, $r_path, $split=self::SPLIT_BY_DAY, $col_spr=self::DEF_COL_SPR)
    {/*{{{*/
        if(isset(self::$_log_conf_container[$key]))
        {
            return ;
        }

        $suffix = self::_makeFileSuffix($split);
        $a_path = self::_makeLogPath($key, $r_path, $suffix);

        self::$_log_conf_container[$key] = array(
            'split'   => $split,
            'suffix'  => $suffix,
            'r_path'  => $r_path,
            'a_path'  => $a_path,
            'col_spr' => $col_spr,
        );
    }/*}}}*/

    /**
        * @brief called for write log
        *
        * @param $key
        * @param $data
        * @param $write_line_header
        *
        * @return 
     */
    public static function log($key, $data, $write_line_header=true)
    {/*{{{*/
        if(!array_key_exists($key, self::$_log_conf_container))
        {
            return false;
        }

        $conf   = self::$_log_conf_container[$key];
        $suffix = self::_makeFileSuffix($conf['split']);
        $a_path = '';
        if($suffix != $conf['suffix'])
        {
            $a_path = self::_makeLogPath($key, $conf['r_path'], $suffix);

            self::$_log_conf_container[$key]['suffix'] = $suffix;
            self::$_log_conf_container[$key]['a_path'] = $a_path;
        }
        else
        {
            $a_path = $conf['a_path'];
        }

        self::_writeLog($a_path, $data, $conf['col_spr'], $write_line_header);
    }/*}}}*/


    private static function _makeFileSuffix($split)
    {/*{{{*/
        $suffix = '';

        switch($split)
        {
        case self::SPLIT_BY_DAY:
            $suffix = date('Ymd');
            break;
        case self::SPLIT_BY_HOUR:
            $suffix = date('YmdH');
            break;
        }

        return $suffix;
    }/*}}}*/
    private static function _makeLogPath($key, $r_path, $suffix)
    {/*{{{*/
        $result = self::$_log_root.'/';
        if('' != $r_path)
        {
            $result.= $r_path.'/';
        }
        $result.= $key.'.log';
        if('' != $suffix)
        {
            $result.= '.'.$suffix;
        }

        return $result;
    }/*}}}*/
    private static function _makeLineHeader($col_spr)
    {/*{{{*/
        $now = '['.date('Y-m-d H:i:s').']';
        $ip  = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '-';

        return $now.$col_spr.$ip;
    }/*}}}*/

    private static function _writeLog($a_path, $data, $col_spr, $write_line_header)
    {/*{{{*/
        $msg = $write_line_header ? self::_makeLineHeader($col_spr).$col_spr : '';
        if(is_array($data))
        {
            $msg.= implode($col_spr, $data);
        }
        else
        {
            $msg.= $data;
        }
        $msg.= "\n";

        error_log($msg, 3, $a_path);
    }/*}}}*/
}/*}}}*/
