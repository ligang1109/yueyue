<?php
namespace YueYue\View;

class Smarty extends \YueYue\View\Base
{/*{{{*/
    private $_smarty = null;

    public function initSmarty($smarty_home, $smarty_tmp_file_root, $is_dev)
    {/*{{{*/
        include($smarty_home.'/Smarty.class.php');

        $this->_smarty = new \Smarty();

        $this->_smarty->compile_dir     = $smarty_tmp_file_root."/templates_c/";        
        $this->_smarty->cache_dir       = $smarty_tmp_file_root."/cache/";
        $this->_smarty->left_delimiter  = '{%';
        $this->_smarty->right_delimiter = '%}';

        $this->_smarty->setTemplateDir($this->_view_root);
        $this->_smarty->addConfigDir($this->_view_root.'/configs');
        $this->_smarty->addPluginsDir($this->_view_root.'/plugins');
        
        if($is_dev)
        {
            /*开发模式下打开url调试模式和强制关闭缓存*/
            $this->_smarty->smarty_debug_id = 'debug';
            $this->_smarty->debugging_ctrl  = 'URL';
            $this->_smarty->force_compile   = true;
        }
        else
        {
            $this->_smarty->autoload_filters = array('output' => array('strip'));
        }
    }/*}}}*/

    protected function _assign($key, $value)
    {/*{{{*/
        $this->_smarty->assign($key, $value);
    }/*}}}*/
    protected function _getTplPath($tpl_name)
    {/*{{{*/
        return "$this->_view_root/$tpl_name.tpl";
    }/*}}}*/
    protected function _parseTpl($tpl_path)
    {/*{{{*/
        $this->_smarty->display($tpl_path);
    }/*}}}*/
}/*}}}*/
