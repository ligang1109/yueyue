<?php
/**
* @file func.php
* @brief task func interface, every task must implement this
* @author ligang
* @version 1.0
* @date 2014-11-11
 */

namespace YueYue\Task;

interface Func
{/*{{{*/
    public function printHelp();
    public function run($params=array());
}/*}}}*/
