<?php
/**
* @file yueyue.php
* @brief yueyue runner
* @author ligang
* @version 1.0
* @date 2014-10-29
 */

namespace YueYue\Core;

class Yueyue
{/*{{{*/
    private $_controller_namespace = '';
    private $_controller_name      = '';
    private $_action_name          = '';
    private $_tpl_engine           = '';
    private $_view_root            = '';
    private $_log_root             = '';

    private $_router = null;

    public function __construct()
    {/*{{{*/
        $this->_router = \YueYue\Component\Loader::loadRouter();
    }/*}}}*/

    /**
        * @brief set log root e.g. /home/q/system/yueyue/logs
        *
        * @param $log_root
        *
        * @return 
     */
    public function setLogRoot($log_root)
    {/*{{{*/
        $this->_log_root = $log_root;
    }/*}}}*/

    /**
        * @brief set view tpl_engine and view_root
        *
        * @param $tpl_engine
        * @param $view_root
        *
        * @return 
     */
    public function setView($tpl_engine, $view_root)
    {/*{{{*/
        $this->_tpl_engine = $tpl_engine;
        $this->_view_root  = $view_root;
    }/*}}}*/

    /**
        * @brief set controller
        *
        * @param $controller_namespace
        * @param $controller_name
        *
        * @return 
     */
    public function setController($controller_namespace, $controller_name='')
    {/*{{{*/
        $this->_controller_namespace = $controller_namespace;
        $this->_controller_name      = $controller_name;
    }/*}}}*/

    /**
        * @brief set action
        *
        * @param $action_name
        *
        * @return 
     */
    public function setActionName($action_name)
    {/*{{{*/
        $this->_action_name = $action_name;
    }/*}}}*/

    /**
        * @brief run web app
        *
        * @return 
     */
    public function runWeb()
    {/*{{{*/
        \YueYue\Component\Bizlog::init($this->_log_root);
    }/*}}}*/

    /**
        * @brief run task app which add before
        *
        * @return 
     */
    public function runTask()
    {/*{{{*/
        \YueYue\Component\Bizlog::init($this->_log_root);
        \YueYue\Component\Loader::loadTaskRunner()->runTask();
    }/*}}}*/

    /**
        * @brief add task app
        *
        * @param $task_name
        * @param $cls_name
        *
        * @return 
     */
    public function addTask($task_name, $cls_name)
    {/*{{{*/
        \YueYue\Component\Loader::loadTaskRunner()->addTask($task_name, $cls_name);
    }/*}}}*/
}/*}}}*/
