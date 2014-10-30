<?php
namespace YueYue\Task;

interface Func
{/*{{{*/
    public function printHelp();
    public function run($params=array());
}/*}}}*/
