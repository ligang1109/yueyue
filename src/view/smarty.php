<?php
namespace YueYue\View;

//class Smarty extends \YueYue\View\Base
//{/*{{{*/
//    private $_smarty = null;

//    public function __construct()
//    {/*{{{*/
//        parent::__construct();

//        $this->_initSmarty();
//    }/*}}}*/

//    public function assign($key, $value)
//    {/*{{{*/
//        $this->_smarty->assign($key, $value);
//    }/*}}}*/
//    public function parseTplContents($tpl_name)
//    {/*{{{*/
//        $tpl_path = "$this->_view_root/$tpl_name.tpl";
//        if(!file_exists($tpl_path))
//        {
//            return '';
//        }

//        ob_start();
//        $this->_smarty->display($tpl_path);
//        return ob_get_clean();
//    }/*}}}*/


//    private function _initSmarty()
//    {/*{{{*/
//        $smarty_tmp_file_path = Hao360cnRabbit_ServerConf::TMP_ROOT.'/smarty';

//        $this->_smarty = new \Smarty();
//        $this->_smarty->compile_dir     = $smarty_tmp_file_path."/templates_c/";        
//        $this->_smarty->cache_dir       = $smarty_tmp_file_path."/cache/";
//        $this->_smarty->left_delimiter  = '{%';
//        $this->_smarty->right_delimiter = '%}';
//        $this->_smarty->setTemplateDir($this->_view_root);
//        $this->_smarty->addConfigDir($this->_view_root.'/configs');
//        $this->_smarty->addPluginsDir($this->_view_root.'/plugins');
//        
//        if(Hao360cnRabbit_ServerConf::IS_DEV){
//            /*开发模式下打开url调试模式和强制关闭缓存*/
//            $this->_smarty->smarty_debug_id = 'debug';
//            $this->_smarty->debugging_ctrl  = 'URL';
//            $this->_smarty->force_compile   = true;
//        } else {
//            $this->_smarty->autoload_filters = array('output' => array('strip'));
//        }
//    }/*}}}*/
//}/*}}}*/
