<?php
namespace YueYue\Svc;

abstract class Store
{/*{{{*/
	abstract protected function _getEntityName();

	protected $_entity_name = '';

    public function __construct()
    {/*{{{*/
		$this->_entity_name = $this->_getEntityName();
    }/*}}}*/
}/*}}}*/
