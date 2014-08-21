<?php
namespace YueYue\Svc;

abstract class Base
{/*{{{*/
	protected $_serve_name 	 = '';
	protected $_serve_params = array();
    protected $_result       = null;

    public function __construct()
    {/*{{{*/
    }/*}}}*/

    public function serve($serve_name, $params=array())
    {/*{{{*/
		$this->_serve_name   = $serve_name;
        $this->_serve_params = $params;

		$serve_func = '_'.$this->_serve_name;
        if(!method_exists($this, $serve_func))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_SVC_SERVE_NOT_EXISTS, "serve $this->_serve_name not exists");
        }

        $this->_preServe();
        $this->_result = $this->$serve_func();
        $this->_postServe();

        return $this->_result;
    }/*}}}*/

    protected function _preServe()
    {/*{{{*/
    }/*}}}*/
    protected function _postServe()
    {/*{{{*/
    }/*}}}*/
}/*}}}*/
