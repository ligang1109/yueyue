<?php
namespace YueYue\Component;

class Request
{/*{{{*/
    private $_request_params = array();

    public function getParam($key='', $default=null)
    {/*{{{*/
        if('' == $key)
        {
            return array_merge($_GET, $_POST);
        }

        $value = '';
        if(isset($_GET[$key]))
        {
            $value = $_GET[$key];
        }
        else if(isset($_POST[$key]))
        {
            $value = $_POST[$key];
        }
        else
        {
            $value = $default;
        }
        return $value;
    }/*}}}*/
    public function getStrParam($key='', $default='')
    {/*{{{*/
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : $this->_fmtStrValue($value);
    }/*}}}*/
    public function getNumParam($key='', $default=0)
    {/*{{{*/
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : $this->_fmtNumValue($value);
    }/*}}}*/
    public function getArrParam($key='', $default=array())
    {/*{{{*/
        $value = $this->getParam($key, $default);
        return is_null($value) ? null : $this->_fmtArrValue($value);
    }/*}}}*/

    public function parseRequestParams($params_conf)
    {/*{{{*/
        foreach($params_conf->getParamNames() as $name)
        {
            $value = $this->_parseParamValue($name, $params_conf);
            if(is_null($value) && $params_conf->getParamFilterNull($name))
            {
                continue;
            }

            $check = $params_conf->getParamCheckFunc($name);
            if(is_callable($check))
            {
                if(!call_user_func($check, $value))
                {
                    $this->_handingParamError($name, $params_conf);
                }
            }

            $this->_request_params[$name] = $value;
        }
    }/*}}}*/
    public function getRequestParams()
    {/*{{{*/
        return $this->_request_params;
    }/*}}}*/


    private function _fmtStrValue($value)
    {/*{{{*/
        return trim($value);
    }/*}}}*/
    private function _fmtNumValue($value)
    {/*{{{*/
        return intval($value);
    }/*}}}*/
    private function _fmtArrValue($value)
    {/*{{{*/
        foreach($value as $k => $v)
        {
            if(is_array($v))
            {
                $v = $this->_fmtArrValue($v);
            }
            else if(is_numeric($v))
            {
                $v = $this->_fmtNumValue($v);
            }
            else
            {
                $v = $this->_fmtStrValue($v);
            }
            $value[$k] = $v;
        }

        return $value;
    }/*}}}*/

    private function _parseParamValue($name, $params_conf)
    {/*{{{*/
        $default = $params_conf->getParamDefaultValue($name);

        switch($params_conf->getParamType($name))
        {
        case \YueYue\Knowledge\Param::TYPE_STR:
            return $this->getStrParam($name, $default);
        case \YueYue\Knowledge\Param::TYPE_NUM:
            return $this->getNumParam($name, $default);
        case \YueYue\Knowledge\Param::TYPE_ARR:
            return $this->getArrParam($name, $default);
        default:
            return $this->getParam($name, $default);
        }
    }/*}}}*/
    private function _handingParamError($name, $params_conf)
    {/*{{{*/
        switch($params_conf->getParamErrorHanding($name))
        {
        case \YueYue\Knowledge\Param::ERROR_HANDING_EXCEPTION:
            $exception = $params_conf->getParamErrorExceptionClsname($name);
            throw new $exception($params_conf->getParamErrorErrno($name), $params_conf->getParamErrorMsg($name));
        case \YueYue\Knowledge\Param::ERROR_HANDING_USE_DEFAULT:
            $this->_request_params[$name] = $params_conf->getParamDefaultValue($name);
            break;
        case \YueYue\Knowledge\Param::ERROR_HANDING_DISCARD:
        default:
        }
    }/*}}}*/
}/*}}}*/
