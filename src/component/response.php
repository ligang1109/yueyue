<?php
namespace YueYue\Component;

class Response
{/*{{{*/
    const DEF_NAME_FMT            = 'fmt';
    const DEF_NAME_JSONP_CALLBACK = '_callback';

    const DEF_VALUE_FMT_DUMP      = 'dump';
    const DEF_VALUE_FMT_JSON      = 'json';
    const DEF_VALUE_FMT_SERIALIZE = 'serialize';
    const DEF_VALUE_FMT_JSONP     = 'jsonp';

    private $_fmt_name            = '';
    private $_fmt_value_dump      = '';
    private $_fmt_value_json      = '';
    private $_fmt_value_serialize = '';
    private $_fmt_value_jsonp     = '';

    private $_def_fmt = '';

    public function __construct()
    {/*{{{*/
        $this->_fmt_name            = 'fmt';
        $this->_fmt_value_dump      = 'dump';
        $this->_fmt_value_json      = 'json';
        $this->_fmt_value_serialize = 'serialize';
        $this->_fmt_value_jsonp     = 'jsonp';

        $this->_def_fmt = $this->_fmt_value_jsonp;
    }/*}}}*/

    public function setFmtName($name)
    {/*{{{*/
        $this->_fmt_name = $name;
    }/*}}}*/
    public function setFmtValueDump($value)
    {/*{{{*/
        $this->_fmt_value_dump = $value;
    }/*}}}*/
    public function setFmtValueJson($value)
    {/*{{{*/
        $this->_fmt_value_json = $value;
    }/*}}}*/
    public function setFmtValueSerialize($value)
    {/*{{{*/
        $this->_fmt_value_serialize = $value;
    }/*}}}*/
    public function setFmtValueJsonp($value)
    {/*{{{*/
        $this->_fmt_value_jsonp = $value;
    }/*}}}*/
}/*}}}*/



class OldResponse
{/*{{{*/
    const OUTPUT_PARAMS_FMT            = 'fmt';
    const OUTPUT_PARAMS_FMT_DUMP       = 'dump';
    const OUTPUT_PARAMS_FMT_JSON       = 'json';
    const OUTPUT_PARAMS_FMT_SERIALIZE  = 'serialize';
    const OUTPUT_PARAMS_FMT_JSONP      = 'jsonp';
    const OUTPUT_PARAMS_JSONP_CALLBACK = '_callback';

    const DEF_OUTPUT_FMT     = self::OUTPUT_PARAMS_FMT_JSONP;
    const DEF_JSONP_CALLBACK = self::OUTPUT_PARAMS_JSONP_CALLBACK;

    public static function output($data=array(), $params=array())
    {/*{{{*/
        if(empty($params))
        {
            $params = self::_getOutputParams();
        }

        switch($params[self::OUTPUT_PARAMS_FMT])
        {/*{{{*/
        case self::OUTPUT_PARAMS_FMT_DUMP:
            echo '<pre>';
            var_dump($data);
            break;
        case self::OUTPUT_PARAMS_FMT_SERIALIZE:
            echo serialize($data);
            break;
		case self::OUTPUT_PARAMS_FMT_JSONP:
			$callback = array_key_exists(self::OUTPUT_PARAMS_JSONP_CALLBACK, $params) ? self::secureFilter($params[self::OUTPUT_PARAMS_JSONP_CALLBACK]) : self::DEF_JSONP_CALLBACK;
			echo " ".$callback."(".json_encode($data).");";
			break;
        case self::OUTPUT_PARAMS_FMT_JSON:
        default:
            echo json_encode($data);
        }/*}}}*/
    }/*}}}*/
	public static function secureFilter($str, $needHtmlspecialchars=true)
	{/*{{{*/
		return $needHtmlspecialchars ? htmlspecialchars($str) : strip_tags($str);
	}/*}}}*/
	
	public static function outputApiResult($errno, $data=array(), $msg='', $fmt='')
	{/*{{{*/
		$result = array(
			'errno' => $errno,
		);
		if('' != $msg)
		{
			$result['msg'] = $msg;
		}
		if(!empty($data))
		{
			$result['data'] = $data;
		}

		$params = array();
		if('' != $fmt)
		{
			$params[self::OUTPUT_PARAMS_FMT] = $fmt;
		}
        self::output($result, $params);
	}/*}}}*/


    private static function _getOutputParams()
    {/*{{{*/
        $params  = array();
        $request = \YueYue\Component\Loader::loadRequest();

        $params[self::OUTPUT_PARAMS_FMT] = trim($request->getParam(self::OUTPUT_PARAMS_FMT, self::DEF_OUTPUT_FMT));
        if(self::OUTPUT_PARAMS_FMT_JSONP == $params[self::OUTPUT_PARAMS_FMT])
        {
            $callback = trim($request->getParam(self::OUTPUT_PARAMS_JSONP_CALLBACK, self::DEF_JSONP_CALLBACK));
            $params[self::OUTPUT_PARAMS_JSONP_CALLBACK] = $callback;
        }

        return $params;
    }/*}}}*/
}/*}}}*/
