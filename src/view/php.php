<?php
namespace YueYue\View;

class Php extends \YueYue\View\Base
{/*{{{*/
    private $_view_data = array();

    public function __get($key)
    {/*{{{*/
        return array_key_exists($key, $this->_view_data) ? $this->_view_data[$key] : null;
    }/*}}}*/

    public function assign($key, $value, $secure_filter=true)
    {/*{{{*/
        if($secure_filter)
        {
            $value = \YueYue\Tool\Toolbox::secureFilter($value);
        }
        $this->_view_data[$key] = $value;
    }/*}}}*/

    protected function _getTplPath($tpl_name)
    {/*{{{*/
        return "$this->_view_root/$tpl_name.php";
    }/*}}}*/
    protected function _parseTpl($tpl_path)
    {/*{{{*/
		include($tpl_path);
    }/*}}}*/
}/*}}}*/
