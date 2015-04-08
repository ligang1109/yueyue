<?php
/**
* @file web.php
* @brief parse action params, extended by web app
* @author ligang
* @version 1.0
* @date 2014-10-31
 */

namespace YueYue\Controller;

abstract class Web extends \YueYue\Controller\Base
{/*{{{*/
    protected $request     = null;
    protected $params_conf = null;

	public function __construct($controller_name)
	{/*{{{*/
        parent::__construct($controller_name);

        $this->request     = \YueYue\Component\Loader::loadRequest();
        $this->params_conf = new \YueYue\Component\ParamsConf();
	}/*}}}*/

	protected function preAction()
	{/*{{{*/
        parent::preAction();

        $this->parseActionParams();
	}/*}}}*/

    private function parseActionParams()
    {/*{{{*/
        $func = 'set'.ucfirst($this->action_name).'ActionParamsConf';
        if(method_exists($this, $func))
        {
            $this->$func();

            $this->request->parseRequestParams($this->params_conf);
            $this->action_params = $this->request->getRequestParams();
        }
    }/*}}}*/
}/*}}}*/
