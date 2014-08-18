<?php
namespace YueYue\Component;

class ParamsConf
{/*{{{*/
    const KEY_TYPE            = 'type';
    const KEY_DEFAULT         = 'default';
    const KEY_CHECK           = 'check';
    const KEY_FILTER_EMPTY    = 'filter_empty';
    const KEY_ERROR           = 'error';
    const KEY_ERROR_HANDING   = 'handing';
    const KEY_ERROR_EXCEPTION = 'exception';
    const KEY_ERROR_ERRNO     = 'errno';
    const KEY_ERROR_MSG       = 'msg';

    private $_params_conf = array();

    public function setParamType($name, $type)
    {/*{{{*/
        $this->_params_conf[$name][self::KEY_TYPE] = $type;
    }/*}}}*/
    public function setParamDefaultValue($name, $value)
    {/*{{{*/
        $this->_params_conf[$name][self::KEY_DEFAULT] = $value;
    }/*}}}*/
    public function setParamCheckFunc($name, $callback)
    {/*{{{*/
        $this->_params_conf[$name][self::KEY_CHECK] = $callback;
    }/*}}}*/
    public function setParamFilterEmpty($name, $filter=true)
    {/*{{{*/
        $this->_params_conf[$name][self::KEY_FILTER_EMPTY] = $filter;
    }/*}}}*/
    public function setParamErrorHanding($name, $handing)
    {/*{{{*/
        $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_HANDING] = $handing;
    }/*}}}*/
    public function setParamErrorException($name, $exception_clsname, $errno, $msg='')
    {/*{{{*/
        $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_EXCEPTION] = $exception_clsname;
        $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_ERRNO]     = $errno;
        $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_MSG]       = $msg;
    }/*}}}*/

    public function getParamNames()
    {/*{{{*/
        return array_keys($this->_params_conf);
    }/*}}}*/
    public function getParamType($name)
    {/*{{{*/
        return $this->_params_conf[$name][self::KEY_TYPE];
    }/*}}}*/
    public function getParamDefaultValue($name)
    {/*{{{*/
        return $this->_params_conf[$name][self::KEY_DEFAULT];
    }/*}}}*/
    public function getParamCheckFunc($name)
    {/*{{{*/
        return isset($this->_params_conf[$name][self::KEY_CHECK]) ? $this->_params_conf[$name][self::KEY_CHECK] : '';
    }/*}}}*/
    public function getParamFilterEmpty($name)
    {/*{{{*/
        return isset($this->_params_conf[$name][self::KEY_FILTER_EMPTY]) ? $this->_params_conf[$name][self::KEY_FILTER_EMPTY] : false;
    }/*}}}*/
    public function getParamErrorHanding($name)
    {/*{{{*/
        return $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_HANDING];
    }/*}}}*/
    public function getParamErrorExceptionClsname($name)
    {/*{{{*/
        return $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_EXCEPTION];
    }/*}}}*/
    public function getParamErrorErrno($name)
    {/*{{{*/
        return $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_ERRNO];
    }/*}}}*/
    public function getParamErrorMsg($name)
    {/*{{{*/
        return $this->_params_conf[$name][self::KEY_ERROR][self::KEY_ERROR_MSG];
    }/*}}}*/
}/*}}}*/
