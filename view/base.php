<?php
namespace YueYue\View;

abstract class Base
{/*{{{*/
	abstract protected function _assign($key, $value);
    abstract protected function _getTplPath($tpl_name);
	abstract protected function _parseTpl($tpl_path);

	protected $_view_root = '';

	public function setViewRoot($view_root)
	{/*{{{*/
		$this->_view_root = $view_root;
	}/*}}}*/
	public function assign($key, $value, $secure_filter=true)
    {/*{{{*/
        if($secure_filter)
        {
            $value = \YueYue\Tool\Toolbox::secureFilter($value);
        }
        $this->_assign($key, $value);
    }/*}}}*/
	public function render($tpl_name, $data=array(), $echo=true)
	{/*{{{*/
        if(!empty($data))
        {
            foreach($data as $key => $value)
            {
                $this->assign($key, $value);
            }
        }

        $tpl_path = $this->_getTplPath($tpl_name);
        if(!file_exists($tpl_path))
        {
			return '';
        }

		ob_start();
		$this->_parseTpl($tpl_path);
		$contents = ob_get_clean();
        $this->_filterContents($contents);

        if($echo)
        {
            echo $contents;
        }
        else
        {
            return $contents;
        }
	}/*}}}*/

    protected function _filterContents(&$contents)
    {/*{{{*/
    }/*}}}*/
}/*}}}*/
