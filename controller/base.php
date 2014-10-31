<?php
/**
* @file base.php
* @brief base controller
* @author ligang
* @version 1.0
* @date 2014-10-31
 */

namespace YueYue\Controller;

abstract class Base
{/*{{{*/
	protected $_controller_name = '';
	protected $_action_name 	= '';
    protected $_action_params   = array();
    protected $_ext_params      = array();

	public function __construct($controller_name)
	{/*{{{*/
		$this->_controller_name = $controller_name;
	}/*}}}*/

    /**
        * @brief dispatch by controller action
        *
        * @param $action_name
        * @param $ext_params
        *
        * @return 
     */
    public function dispatch($action_name, $ext_params=array())
    {/*{{{*/
        $this->_ext_params  = $ext_params;
		$this->_action_name = strtolower($action_name);

		$action_func = $this->_action_name.'Action';
        if(!method_exists($this, $action_func))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_COMPONENTS_ACTION_NOT_EXISTS, "action $this->_action_name not exists");
        }

        $this->_preAction();
		$this->$action_func();
        $this->_postAction();
    }/*}}}*/

	protected function _preAction()
	{/*{{{*/
	}/*}}}*/
	protected function _postAction()
	{/*{{{*/
	}/*}}}*/
}/*}}}*/
