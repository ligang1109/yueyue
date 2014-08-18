<?php
namespace YueYue\Core;

class YueYue
{/*{{{*/
    private $_subsystem            = '';
    private $_controller_name      = '';
    private $_controller_namespace = '';
    private $_action_name          = '';

    public function __construct($subsystem)
    {/*{{{*/
        $this->_subsystem = $subsystem;
    }/*}}}*/

    public function getSubsystem()
    {/*{{{*/
        return $this->_subsystem;
    }/*}}}*/
    public function setControllerName($controller_name, $controller_namespace)
    {/*{{{*/
        $this->_controller_name      = $controller_name;
        $this->_controller_namespace = $controller_namespace;
    }/*}}}*/
    public function setActionName($action_name)
    {/*{{{*/
        $this->_action_name = $action_name;
    }/*}}}*/

    public function runWeb()
    {/*{{{*/
        $controller = \YueYue\Component\Loader::loadWebController($this->_controller_name, $this->_controller_namespace);
        $controller->dispatch($this->_action_name);
    }/*}}}*/
}/*}}}*/


include(__DIR__.'/autoload.php');
\YueYue\Core\Autoload::init('YueYue', __DIR__.'/../');
