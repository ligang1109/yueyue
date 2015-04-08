<?php
namespace YueYue\Component;

class Exception extends \Exception
{/*{{{*/
	protected $_ext = null;

    public function __construct($errno, $msg='', $ext=null)
    {/*{{{*/
        $msg = ('' === $msg) ? \YueYue\Knowledge\Errno::getErrorMsg($errno) : $msg;
		$this->_ext = $ext;

        parent::__construct($msg, $errno);
    }/*}}}*/

	public function getExt()
	{/*{{{*/
		return $this->_ext;
	}/*}}}*/
}/*}}}*/
