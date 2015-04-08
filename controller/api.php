<?php
/**
* @file api.php
* @brief no view, use response, extends by api app
* @author ligang
* @version 1.0
* @date 2014-10-31
 */

namespace YueYue\Controller;

abstract class Api extends \YueYue\Controller\Web
{/*{{{*/
    protected $response = null;
    protected $result   = array();
    protected $fmt      = '';

	public function __construct($controller_name)
	{/*{{{*/
        parent::__construct($controller_name);

        $this->response = \YueYue\Component\Loader::loadResponse();
	}/*}}}*/

	protected function postAction()
	{/*{{{*/
        parent::postAction();

        $this->response->output($this->result, $this->fmt);
	}/*}}}*/
}/*}}}*/
