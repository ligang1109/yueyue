<?php
/**
* @file front.php
* @brief have view, extended by front app
* @author ligang
* @version 1.0
* @date 2014-10-31
 */

namespace YueYue\Controller;

abstract class Front extends \YueYue\Controller\Web
{/*{{{*/
    protected $_view     = null;
    protected $_tpl_name = '';

    protected function _preAction()
    {/*{{{*/
        parent::_preAction();

        if('' != $this->_ext_params['tpl_engine'])
        {
            $this->_view = \YueYue\Component\Loader::loadView($this->_ext_params['tpl_engine']);
            $this->_view->setViewRoot($this->_ext_params['view_root']);
        }
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

    protected function _setViewTpl($tpl_name)
    {/*{{{*/
        $this->_tpl_name = $tpl_name;
    }/*}}}*/
    protected function _setNoView()
    {/*{{{*/
        $this->_view = null;
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
