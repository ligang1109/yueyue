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
    public static function getPort()
    {/*{{{*/
        return $_SERVER['REMOTE_PORT'];
    }/*}}}*/
    public static function getHostname()
    {/*{{{*/
        $host_data = posix_uname();
        return $host_data['nodename'];
    }/*}}}*/
    public static function getUa()
    {/*{{{*/
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }/*}}}*/
    public static function getDomain()
    {/*{{{*/
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }/*}}}*/
    public static function getQueryString()
    {/*{{{*/
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }/*}}}*/
    public static function getRefer()
    {/*{{{*/
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    }/*}}}*/
    public static function getRequestUri()
    {/*{{{*/
        return $_SERVER['REQUEST_URI'];
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
	public static function secureFilter($data, $needHtmlspecialchars=true)
	{/*{{{*/
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                $data[$key] = self::secureFilter($value, $needHtmlspecialchars);
            }
        }
        else
        {
            $data = $needHtmlspecialchars ? htmlspecialchars($data) : strip_tags($data);
        }

        return $data;
	}/*}}}*/

	public static function isTextFile($file_path)
	{/*{{{*/
		$result = self::runShellCmd("file $file_path", true);
		return (false === strpos($result['last_line'], 'text')) ? false : true;
	}/*}}}*/
	public static function getFilesFromPath($path, &$result, $filter_str='')
	{/*{{{*/
		if(!file_exists($path))
		{
			return ;
		}
		if(preg_match('/^\./', $path))
		{
			return ;
		}

		if(is_dir($path))
		{
			if(false !== ($dh = opendir($path)))
			{
				while(false !== ($file = readdir($dh)))
				{
					if('.' != $file && '..' != $file)
					{
						self::getFilesFromPath("$path/$file", $result, $filter_str);
					}
				}
			}
		}
		else
		{
			$result[] = ('' == $filter_str) ? $path : str_replace($filter_str, '', $path);
		}
	}/*}}}*/
    public static function getFileExtension($path)
    {/*{{{*/
        $info = pathinfo($path);
        return $info['extension'];
    }/*}}}*/

    public static function setCssHeader()
    {/*{{{*/
        header('Content-Type:text/css; charset=utf-8');
    }/*}}}*/
    public static function setJsHeader()
    {/*{{{*/
        header('Content-Type:application/x-javascript; charset=utf-8');
    }/*}}}*/
}/*}}}*/
