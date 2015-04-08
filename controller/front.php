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
    protected $view            = null;
    protected $tpl_name        = '';
    protected $tpl_path_prefix = '';

    protected function preAction()
    {/*{{{*/
        parent::preAction();

        if('' != $this->ext_params['tpl_engine'])
        {
            $this->view = \YueYue\Component\Loader::loadView($this->ext_params['tpl_engine']);
            $this->view->setViewRoot($this->ext_params['view_root']);
        }
    }/*}}}*/
	protected function postAction()
	{/*{{{*/
        parent::postAction();

        if(!is_null($this->view))
        {
            if('' == $this->tpl_name)
            {
                if('' != $this->tpl_path_prefix)
                {
                    $this->tpl_name = $this->tpl_path_prefix.'/';
                }
                $this->tpl_name.= $this->controller_name.'/'.$this->action_name;
            }

            $this->view->render($this->tpl_name);
        }
	}/*}}}*/

    protected function setViewTpl($tpl_name)
    {/*{{{*/
        $this->tpl_name = $tpl_name;
    }/*}}}*/
    protected function setNoView()
    {/*{{{*/
        $this->view = null;
    }/*}}}*/
    protected function assign($key, $value, $secure_filter=true)
    {/*{{{*/
        $this->view->assign($key, $value, $secure_filter);
    }/*}}}*/

    protected function goBack()
    {/*{{{*/
        \YueYue\Tool\Toolbox::jumpTo(\YueYue\Tool\Toolbox::getRefer());
    }/*}}}*/
}/*}}}*/
