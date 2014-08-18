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
        $this->_setActionParamsConf();
        $this->_request->parseRequestParams($this->_params_conf);
        $this->_action_params = $this->_request->getRequestParams();
	}/*}}}*/
	protected function _postAction()
	{/*{{{*/
	}/*}}}*/

    private function _setActionParamsConf()
    {/*{{{*/
        $func = '_set'.ucfirst($this->_action_name).'ActionParamsConf';
        $this->$func();
    }/*}}}*/
}/*}}}*/




abstract class OldWeb
{/*{{{*/
	abstract protected function _getControllerRequestParamsConf();

	private $_view_system = null;
	private $_view_tpl 	  = null;

    protected $_request = null;

	public function run($action_name, $use_smarty)
	{/*{{{*/
		$this->_action_name = $action_name;
		$this->_initViewSystem($use_smarty);
        $this->_initRequestParams();

		$action_func = $action_name.'Action';
		$this->_preAction();
		$this->$action_func();
		$this->_postAction();

		if(!is_null($this->_view_tpl))
		{
			$this->_view_system->render($this->_view_tpl);
		}
	}/*}}}*/


	protected function _preAction()
	{/*{{{*/
	}/*}}}*/
	protected function _postAction()
	{/*{{{*/
	}/*}}}*/

	protected function _assign($key, $value)
	{/*{{{*/
		$this->_view_system->assign($key, $value);
	}/*}}}*/
	protected function _setViewTpl($tpl_name, $add_controller=true)
	{/*{{{*/
		$this->_view_tpl = $add_controller ? "$this->_controller_name/$tpl_name" : $tpl_name;
	}/*}}}*/
	protected function _setNoViewRender()
	{/*{{{*/
		$this->_view_tpl = null;
	}/*}}}*/
	protected function _setViewPath($key)
	{/*{{{*/
		$this->_view_system->setViewPath($key);
	}/*}}}*/

    protected function _goTo($url)
    {/*{{{*/
        header('location:'.$url);
        exit;
    }/*}}}*/


	private function _initViewSystem($use_smarty)
	{/*{{{*/
		$this->_view_system = Hao360cnRabbit_LoaderSvc::loadView($use_smarty);
		$this->_setViewTpl($this->_action_name);
	}/*}}}*/
    private function _initRequestParams()
    {/*{{{*/
        $controller_request_params_conf = $this->_getControllerRequestParamsConf();
        if(array_key_exists($this->_action_name, $controller_request_params_conf))
        {
            $action_request_params_conf = $controller_request_params_conf[$this->_action_name];
            $this->_request_params 		= Hao360cnRabbit_RequestSvc::getRequestParams($action_request_params_conf);
        }
    }/*}}}*/
	private function _render($tpl_name, $add_controller=true)
	{/*{{{*/
		$this->_view_system->render($tpl_name, $add_controller);
	}/*}}}*/
}/*}}}*/
