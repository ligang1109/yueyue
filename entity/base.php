<?php
namespace YueYue\Entity;

abstract class Base
{/*{{{*/
    abstract protected function _getAttrs();

    protected $_attrs = array();

    public function __construct()
    {/*{{{*/
        $this->_attrs = $this->_getAttrs();
    }/*}}}*/
    public function __get($key)
    {/*{{{*/
        if($this->have($key))
        {
            return $this->_attrs[$key];
        }
        return null;
    }/*}}}*/
    public function __set($key, $value)
    {/*{{{*/
        if($this->have($key))
        {
            $this->_attrs[$key] = $value;
        }
    }/*}}}*/

    public function have($key)
    {/*{{{*/
        return isset($this->_attrs[$key]) ? true : false;
    }/*}}}*/
    public function toAry()
    {/*{{{*/
        return $this->_attrs;
    }/*}}}*/

    public function setAttrs($item=array())
    {/*{{{*/
        foreach($this->_attrs as $key => $value)
        {
            if(isset($item[$key]))
            {
                $this->_attrs[$key] = $item[$key];
            }
        }
    }/*}}}*/

    protected function _bindAttrs($attrs=array())
    {/*{{{*/
        $this->_attrs = array_merge($this->_attrs, $attrs);
    }/*}}}*/
}/*}}}*/
