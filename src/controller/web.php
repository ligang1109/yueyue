<?php
namespace YueYue\Controller;

abstract class Web extends \YueYue\Controller\Base
{/*{{{*/
    protected $_request     = null;
    protected $_params_conf = null;

	public function __construct($controller_name)
	{/*{{{*/
        parent::__construct($controller_name);

        $this->_request     = \YueYue\Component\Loader::loadRequest();
        $this->_params_conf = new \YueYue\Component\ParamsConf();
	}/*}}}*/

	protected function _preAction()
	{/*{{{*/
        parent::_preAction();

        $this->_parseActionParams();
	}/*}}}*/

    private function _parseActionParams()
    {/*{{{*/
        $func = '_set'.ucfirst($this->_action_name).'ActionParamsConf';
        if(method_exists($this, $func))
        {
            $this->$func();

            $this->_request->parseRequestParams($this->_params_conf);
            $this->_action_params = $this->_request->getRequestParams();
        }
    }/*}}}*/
}/*}}}*/
