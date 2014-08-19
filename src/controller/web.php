<?php
namespace YueYue\Controller;

abstract class Web extends \YueYue\Controller\Base
{/*{{{*/
    protected $_request     = null;
    protected $_params_conf = null;
    protected $_view        = null;
    protected $_tpl_name    = '';

	public function __construct($controller_name)
	{/*{{{*/
        parent::__construct($controller_name);

        $this->_request     = \YueYue\Component\Loader::loadRequest();
        $this->_params_conf = new \YueYue\Component\ParamsConf();
	}/*}}}*/

    public function initView($tpl_engine, $view_root)
    {/*{{{*/
        if($tpl_engine)
        {
            $this->_view = \YueYue\Component\Loader::loadView($tpl_engine);
            $this->_view->setViewRoot($view_root);
        }
    }/*}}}*/
    public function setViewTpl($tpl_name)
    {/*{{{*/
        $this->_tpl_name = $tpl_name;
    }/*}}}*/
    public function setNoView()
    {/*{{{*/
        $this->_view = null;
    }/*}}}*/

	protected function _preAction()
	{/*{{{*/
        $this->_parseActionParams();
	}/*}}}*/
	protected function _postAction()
	{/*{{{*/
        if(!is_null($this->_view))
        {
            $tpl_name = $this->_tpl_name ? $this->_tpl_name : "$this->_controller_name/$this->_action_name";
            $this->_view->render($tpl_name);
        }
	}/*}}}*/
    protected function _assign($key, $value)
    {/*{{{*/
        $this->_view->assign($key, $value);
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
	private function _render($tpl_name)
	{/*{{{*/
		$this->_view_system->render($tpl_name);
	}/*}}}*/
}/*}}}*/
