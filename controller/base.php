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
	protected $controller_name = '';
	protected $action_name 	   = '';
    protected $action_params   = array();
    protected $ext_params      = array();

	public function __construct($controller_name)
	{/*{{{*/
		$this->controller_name = $controller_name;
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
        $this->ext_params  = $ext_params;
		$this->action_name = strtolower($action_name);

		$action_func = $this->action_name.'Action';
        if(!method_exists($this, $action_func))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_COMPONENTS_ACTION_NOT_EXISTS, "action $this->action_name not exists");
        }

        $this->preAction();
		$this->$action_func();
        $this->postAction();
    }/*}}}*/

	protected function preAction()
	{/*{{{*/
	}/*}}}*/
	protected function postAction()
	{/*{{{*/
	}/*}}}*/
}/*}}}*/
