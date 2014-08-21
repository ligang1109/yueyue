<?php
namespace YueYue\Svc;

abstract class Store extends \YueYue\Svc\Base
{/*{{{*/
	abstract protected function _getEntityName();

	protected $_entity_name = '';

    public function __construct()
    {/*{{{*/
        parent::__construct();

		$this->_entity_name = $this->_getEntityName();
    }/*}}}*/
}/*}}}*/
