<?php
/**
* @file runner.php
* @brief task runner
* @author ligang
* @version 1.0
* @date 2014-11-11
 */

namespace YueYue\Task;

class Runner
{/*{{{*/
    const ARG_KEY_SPR = '=';

    private $_cmd_list  = array();
    private $_task_list = array();

    public function __construct()
    {/*{{{*/
        $this->_initCmdList();
    }/*}}}*/


    /**
        * @brief add task item
        *
        * @param $task_name
        * @param $cls_name
        *
        * @return 
     */
    public function addTask($task_name, $cls_name)
    {/*{{{*/
        $this->_task_list[$task_name] = $cls_name;
    }/*}}}*/

    /**
        * @brief run task by cmd
        *
        * @return 
     */
    public function runTask()
    {/*{{{*/
        if($_SERVER['argc'] < 2)
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_TASK_INVALID_ARGS, 'invalid args');
        }

        $cmd = $_SERVER['argv'][1];
        if(!isset($this->_cmd_list[$cmd]))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_TASK_INVALID_CMD, 'invalid cmd');
        }

        $func = $this->_cmd_list[$cmd]['func'];
        $this->$func();
    }/*}}}*/


    private function _initCmdList()
    {/*{{{*/
        $this->_cmd_list = array(
            'help' => array(
                'desc' => '打印help，可选参数: [task]',
                'func' => '_printHelp',
            ),
            'list' => array(
                'desc' => '打印task_list',
                'func' => '_printTaskList',
            ),
            'run' => array(
                'desc' => 'run_task，必需参数：[task]，可选参数：[args]',
                'func' => '_runTask',
            ),
        );
    }/*}}}*/
    private function _runTask()
    {/*{{{*/
        $args = array_slice($_SERVER['argv'], 2);
        if(empty($args))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_TASK_INVALID_ARGS, 'invalid args');
        }

        $task_name = array_shift($args);
        if(!isset($this->_task_list[$task_name]))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_TASK_INVALID_TASK_NAME, 'invalid task_name');
        }

        $params   = $this->_parseTaskParams($args);
        $cls_name = $this->_task_list[$task_name];
        try
        {
            $task = new $cls_name();
        }
        catch(\Exception $e)
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_TASK_INVALID_TASK_CLS, "task $cls_name not exists");
        }
        if(!($task instanceof \YueYue\Task\Func))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_TASK_INVALID_TASK_CLS, $cls_name.' must implement \YueYue\Task\Func');
        }

        $task->run($params);
    }/*}}}*/
    private function _parseTaskParams($args)
    {/*{{{*/
        $result = array();
        foreach($args as $arg)
        {
            $arg = explode(self::ARG_KEY_SPR, $arg);
            $result[$arg[0]] = $arg[1];
        }
        return $result;
    }/*}}}*/
}/*}}}*/
