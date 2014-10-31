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
    protected $_response = null;
    protected $_result   = array();
    protected $_fmt      = '';

	public function __construct($controller_name)
	{/*{{{*/
        parent::__construct($controller_name);

        $this->_response = \YueYue\Component\Loader::loadResponse();
	}/*}}}*/

	protected function _postAction()
	{/*{{{*/
        parent::_postAction();

        $this->_response->output($this->_result, $this->_fmt);
	}/*}}}*/
}/*}}}*/
