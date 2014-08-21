<?php
abstract class Hao360cnMisc_BaseEntity
{/*{{{*/
    private $_attr = array();

    abstract protected function _getPrivateCols();

    public function __construct($attr=array())
    {/*{{{*/
        $cols = array_merge($this->_getPublicCols(), $this->_getPrivateCols());
        $cols = $this->_fillCols($cols, $attr);

        $this->_attr = $cols;
    }/*}}}*/
    public function __get($key)
    {/*{{{*/
        if($this->have($key))
        {
            return $this->_attr[$key];
        }
        return null;
    }/*}}}*/
    public function __set($key, $value)
    {/*{{{*/
        $this->_attr[$key] = $value;
    }/*}}}*/

    public function have($key)
    {/*{{{*/
        return array_key_exists($key, $this->_attr) ? true : false;
    }/*}}}*/
    public function toAry()
    {/*{{{*/
        return $this->_attr;
    }/*}}}*/

    public function prepareStore()
    {/*{{{*/
        $this->_fillPublicCols();
    }/*}}}*/
    public function getUpdateFields($params)
    {/*{{{*/
        $result = array();
        foreach($params as $key => $value)
        {
            if($this->have($key))
            {
                if($this->$key != $value)
                {
                    $result[$key] = $value;
                }
            }
        }
        if(!empty($result))
        {
            $result['edit_time'] = $this->_getNow();
        }
        return $result;
    }/*}}}*/

    protected function _fillCols($cols, $attr)
    {/*{{{*/
        foreach($cols as $key => $value)
        {
            if(isset($attr[$key]))
            {
                $cols[$key] = $attr[$key];
            }
        }
        return $cols;
    }/*}}}*/
    protected function _fillPublicCols()
    {/*{{{*/
        $now = $this->_getNow();

        $this->add_time  = $now;
        $this->edit_time = $now;
    }/*}}}*/

    protected function _getPublicCols()
    {/*{{{*/
        return array(
            'id'        => 0,
            'add_time'  => '',
            'edit_time' => '',
        );
    }/*}}}*/
    protected function _getNow()
    {/*{{{*/
        return date('Y-m-d H:i:s');
    }/*}}}*/
}/*}}}*/
