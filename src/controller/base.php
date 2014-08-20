<?php
namespace YueYue\Controller;

abstract class Base
{/*{{{*/
	protected $_controller_name = '';
	protected $_action_name 	= '';
    protected $_action_params   = array();

	public function __construct($controller_name)
	{/*{{{*/
		$this->_controller_name = $controller_name;
	}/*}}}*/

    public function dispatch($action_name)
    {/*{{{*/
		$this->_action_name = $action_name;

		$action_func = $action_name.'Action';
        if(!method_exists($this, $action_func))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_COMPONENTS_ACTION_NOT_EXISTS, "action $this->_action_name not exists");
        }

        $this->_preAction();
		$this->$action_func();
        $this->_postAction();
    }/*}}}*/
    public function setActionParams($params=array())
    {/*{{{*/
        $this->_action_params = $params;
    }/*}}}*/

	protected function _preAction()
	{/*{{{*/
	}/*}}}*/
	protected function _postAction()
	{/*{{{*/
	}/*}}}*/
}/*}}}*/
