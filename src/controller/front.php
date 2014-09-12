<?php
namespace YueYue\Controller;

abstract class Front extends \YueYue\Controller\Web
{/*{{{*/
    protected $_view     = null;
    protected $_tpl_name = '';

    public function initView($tpl_engine, $view_root)
    {/*{{{*/
        if($tpl_engine)
        {
            $this->_view = \YueYue\Component\Loader::loadView($tpl_engine);
            $this->_view->setViewRoot($view_root);
        }
    }/*}}}*/
    public function setViewTpl($tpl_name)
    {/*{{{*/
        $this->_tpl_name = $tpl_name;
    }/*}}}*/
    public function setNoView()
    {/*{{{*/
        $this->_view = null;
    }/*}}}*/

	protected function _postAction()
	{/*{{{*/
        parent::_postAction();

        if(!is_null($this->_view))
        {
            $tpl_name = $this->_tpl_name ? $this->_tpl_name : $this->_controller_name.'/'.$this->_action_name;
            $this->_view->render($tpl_name);
        }
	}/*}}}*/
    protected function _assign($key, $value, $secure_filter=true)
    {/*{{{*/
        $this->_view->assign($key, $value, $secure_filter);
    }/*}}}*/

    protected function _getCurUrl()
    {/*{{{*/
        return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }/*}}}*/
    protected function _getBackUrl()
    {/*{{{*/
        return array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '';
    }/*}}}*/
    protected function _goBack()
    {/*{{{*/
        header('location:'.$this->_getBackUrl());
        exit;
    }/*}}}*/
}/*}}}*/
