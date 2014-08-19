<?php
namespace YueYue\Controller;

abstract class Api extends \YueYue\Controller\Web
{/*{{{*/
    protected $_response = null;
    protected $_result   = array();

	public function __construct($controller_name)
	{/*{{{*/
        parent::__construct($controller_name);

        $this->_response = \YueYue\Component\Loader::loadResponse();
	}/*}}}*/

	protected function _postAction()
	{/*{{{*/
        parent::_postAction();

        $this->_response->output
	}/*}}}*/
}/*}}}*/
