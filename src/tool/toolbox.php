<?php
namespace YueYue\Tool;

class Toolbox
{/*{{{*/
    public static function runShell($shell, $params=array(), $fetch_output=false)
    {/*{{{*/
        $params = implode(' ', $params);
        $cmd    = "$shell $params";
        return self::runShellCmd($cmd, $fetch_output);
    }/*}}}*/
    public static function runShellCmd($cmd, $fetch_output=false)
    {/*{{{*/
        $return_var = 0;
        $last_line  = '';
        $output     = '';

        ob_start();
        $last_line  = system($cmd, $return_var);
        $cmd_output = ob_get_clean();

        if($fetch_output)
        {
            $output = $cmd_output;
        }
        else
        {
            echo $cmd_output;
        }

        return array(
            'return_var' => $return_var,
            'last_line'  => $last_line,
            'output'     => $output,
        );
    }/*}}}*/
    public static function getParamsFromShell($shell, $params_map)
    {/*{{{*/
        $cmd = "source $shell; ";
        foreach($params_map as $key => $value)
        {
            $cmd.= 'echo $'.$value.'; ';
        }

        $result = self::runShellCmd($cmd, true);
        $output = explode("\n", $result['output']);

        $result = array();
        $i      = 0;
        foreach($params_map as $key => $value)
        {
            $result[$key] = $output[$i];
            $i++;
        }

        return $result;
    }/*}}}*/

    public static function getIp()
    {/*{{{*/
        return $_SERVER['REMOTE_ADDR'];
    }/*}}}*/
    public static function getHostname()
    {/*{{{*/
        $host_data = posix_uname();
        return $host_data['nodename'];
    }/*}}}*/
    public static function jumpTo($url)
    {/*{{{*/
        header('location:'.$url);
        exit;
    }/*}}}*/
    public static function getNowDate()
    {/*{{{*/
        return date('Y-m-d H:i:s');
    }/*}}}*/
}/*}}}*/
