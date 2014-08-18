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

    public function setSubsystem($subsystem)
    {/*{{{*/
        $this->_subsystem = $subsystem;
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

    public function runWeb()
    {/*{{{*/
        $controller = \YueYue\Component\Loader::loadWebController($this->_controller_namespace, $this->_controller_name);

        $controller->initView($this->_tpl_engine, $this->_view_root);
        $controller->dispatch($this->_action_name);
    }/*}}}*/
}/*}}}*/
