<?php
namespace YueYue\Core;

class Yueyue
{/*{{{*/
    private $_subsystem            = '';
    private $_controller_namespace = '';
    private $_controller_name      = '';
    private $_action_name          = '';
    private $_tpl_engine           = '';
    private $_view_root            = '';
    private $_log_root             = '';

    public function setSubsystem($subsystem)
    {/*{{{*/
        $this->_subsystem = $subsystem;
    }/*}}}*/
    public function setLogRoot($log_root)
    {/*{{{*/
        $this->_log_root = $log_root;
    }/*}}}*/
    public function setView($tpl_engine, $view_root)
    {/*{{{*/
        $this->_tpl_engine = $tpl_engine;
        $this->_view_root  = $view_root;
    }/*}}}*/
    public function setController($controller_namespace, $controller_name='')
    {/*{{{*/
        $this->_controller_namespace = $controller_namespace;
        $this->_controller_name      = $controller_name;
    }/*}}}*/
    public function setActionName($action_name)
    {/*{{{*/
        $this->_action_name = $action_name;
    }/*}}}*/

    public function getSubsystem()
    {/*{{{*/
        return $this->_subsystem;
    }/*}}}*/

    public function runFront()
    {/*{{{*/
        $this->_initLogger();

        $controller = $this->_loadController();
        $controller->initView($this->_tpl_engine, $this->_view_root);
        $controller->dispatch($this->_action_name);
    }/*}}}*/
    public function runApi()
    {/*{{{*/
        $this->_initLogger();

        $controller = $this->_loadController();
        $controller->dispatch($this->_action_name);
    }/*}}}*/
    public function runTask()
    {/*{{{*/
        $this->_initLogger();

        \YueYue\Component\Loader::loadTaskRunner()->runTask();
    }/*}}}*/

    public function addTask($task_name, $cls_name)
    {/*{{{*/
        \YueYue\Component\Loader::loadTaskRunner()->addTask($task_name, $cls_name);
    }/*}}}*/


    private function _initLogger()
    {/*{{{*/
        \YueYue\Component\Logger::init($this->_log_root);
    }/*}}}*/
    private function _loadController()
    {/*{{{*/
        try
        {
            return \YueYue\Component\Loader::loadController($this->_controller_namespace, $this->_controller_name);
        }
        catch(\Exception $e)
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_COMPONENTS_CONTROLLER_NOT_EXISTS, "controller $this->_controller_name not exists");
        }
    }/*}}}*/
}/*}}}*/
