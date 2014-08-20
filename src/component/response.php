<?php
namespace YueYue\Component;

class Response
{/*{{{*/
    const FMT_DUMP      = 1;
    const FMT_JSON      = 2;
    const FMT_SERIALIZE = 3;
    const FMT_JSONP     = 4;

    const DEF_FMT_NAME            = 'fmt';
    const DEF_JSONP_CALLBACK_NAME = '_callback';
    const DEF_FMT_VALUE_DUMP      = 'dump';
    const DEF_FMT_VALUE_JSON      = 'json';
    const DEF_FMT_VALUE_SERIALIZE = 'serialize';
    const DEF_FMT_VALUE_JSONP     = 'jsonp';

    const DEF_FMT_KEY              = self::FMT_JSON;
    const DEF_JSONP_CALLBACK_VALUE = self::DEF_JSONP_CALLBACK_NAME;

    private $_fmt_name            = '';
    private $_fmt_value           = '';
    private $_fmt_conf_key_value  = array();
    private $_fmt_conf_value_key  = array();
    private $_jsonp_callback_name = '';

    private $_request = null;

    public function __construct()
    {/*{{{*/
        $this->_fmt_name            = self::DEF_FMT_NAME;
        $this->_jsonp_callback_name = self::DEF_JSONP_CALLBACK_NAME;
        $this->_initFmtConf();

        $this->_request = \YueYue\Component\Loader::loadRequest();
    }/*}}}*/

    public function setFmtName($name)
    {/*{{{*/
        $this->_fmt_name = $name;
    }/*}}}*/
    public function setFmtValue($value)
    {/*{{{*/
        $this->_fmt_value = $value;
    }/*}}}*/
    public function setJsonpCallbackName($name)
    {/*{{{*/
        $this->_jsonp_callback_name = $name;
    }/*}}}*/
    public function setFmtValueDump($value)
    {/*{{{*/
        $this->_setFmtConf(self::FMT_DUMP, $value);
    }/*}}}*/
    public function setFmtValueJson($value)
    {/*{{{*/
        $this->_setFmtConf(self::FMT_JSON, $value);
    }/*}}}*/
    public function setFmtValueSerialize($value)
    {/*{{{*/
        $this->_setFmtConf(self::FMT_SERIALIZE, $value);
    }/*}}}*/
    public function setFmtValueJsonp($value)
    {/*{{{*/
        $this->_setFmtConf(self::FMT_JSONP, $value);
    }/*}}}*/

	public function secureFilter($str, $needHtmlspecialchars=true)
	{/*{{{*/
		return $needHtmlspecialchars ? htmlspecialchars($str) : strip_tags($str);
	}/*}}}*/
    public function output($data=array(), $fmt_value='')
    {/*{{{*/
        $fmt_key = $this->_getFmtKey($fmt_value);

        switch($fmt_key)
        {
        case self::FMT_DUMP:
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
            break;
        case self::FMT_SERIALIZE:
            echo serialize($data);
            break;
        case self::FMT_JSONP:
			echo ' '.$this->_getJsonpCallback().'('.json_encode($data).');';
			break;
        case self::FMT_JSON:
        default:
            echo json_encode($data);
        }
    }/*}}}*/


    private function _initFmtConf()
    {/*{{{*/
        $this->_fmt_conf_key_value = array(
            self::FMT_DUMP      => self::DEF_FMT_VALUE_DUMP,
            self::FMT_JSON      => self::DEF_FMT_VALUE_JSON,
            self::FMT_SERIALIZE => self::DEF_FMT_VALUE_SERIALIZE,
            self::FMT_JSONP     => self::DEF_FMT_VALUE_JSONP,
        );

        $this->_fmt_conf_value_key = array(
            self::DEF_FMT_VALUE_DUMP      => self::FMT_DUMP,
            self::DEF_FMT_VALUE_JSON      => self::FMT_JSON,
            self::DEF_FMT_VALUE_SERIALIZE => self::FMT_SERIALIZE,
            self::DEF_FMT_VALUE_JSONP     => self::FMT_JSONP,
        );
    }/*}}}*/
    private function _setFmtConf($key, $value)
    {/*{{{*/
        $old_value = $this->_fmt_conf_key_value[$key];
        unset($this->_fmt_conf_value_key[$old_value]);

        $this->_fmt_conf_key_value[$key]   = $value;
        $this->_fmt_conf_value_key[$value] = $key;
    }/*}}}*/
    private function _getFmtKey($fmt_value)
    {/*{{{*/
        if('' == $fmt_value)
        {
            if('' == $this->_fmt_value)
            {
                $fmt_value = $this->_request->getStrParam($this->_fmt_name, '');
                if('' == $fmt_value)
                {
                    $fmt_value = $this->_fmt_conf_key_value[self::DEF_FMT_KEY];
                }
            }
            else
            {
                $fmt_value = $this->_fmt_value;
            }
        }
        if(!isset($this->_fmt_conf_value_key[$fmt_value]))
        {
            $fmt_value = $this->_fmt_conf_key_value[self::DEF_FMT_KEY];
        }

        return $this->_fmt_conf_value_key[$fmt_value];
    }/*}}}*/
    private function _getJsonpCallback()
    {/*{{{*/
        $callback = $this->_request->getStrParam($this->_jsonp_callback_name, '');
        if('' == $callback)
        {
            $callback = self::DEF_JSONP_CALLBACK_VALUE;
        }

        return $this->secureFilter($callback);
    }/*}}}*/
}/*}}}*/
