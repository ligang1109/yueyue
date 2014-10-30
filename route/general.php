<?php
/**
* @file general.php
* @brief general route use tradition controller action, e.g. /controller/action
* @author ligang
* @version 1.0
* @date 2014-10-30
 */

namespace YueYue\Route;

class General extends \YueYue\Route\Base
{/*{{{*/
    const DEF_CONTROLLER = 'index';
    const DEF_ACTION     = 'index';

    private $_ext_params = array();

    public function go($ext_params=array())
    {/*{{{*/
        $this->_ext_params = $ext_params;

        $controller_namespace = $this->_getParamsValue('controller_namespace');
        if('' == $controller_namespace)
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_SYS_INVALID_CONTROLLER, "you must set controller namespace");
        }

        $controller_name = $this->_getParamsValue('controller_name');
        $action_name     = $this->_getParamsValue('action_name');

        $uri      = trim($this->_request_uri, '/');
        $uri_data = ('' == $uri) ? array() : explode('/', $uri);

        if('' == $controller_name)
        {
            $controller_name = isset($uri_data[0]) ? $uri_data[0] : self::DEF_CONTROLLER;
        }
        if('' == $action_name)
        {
            $action_name = isset($uri_data[1]) ? $uri_data[1] : self::DEF_ACTION;
        }

        \YueYue\Component\Loader::loadController($controller_namespace, $controller_name)->dispatch($action_name, $this->_ext_params);
    }/*}}}*/


    private function _getParamsValue($name, $default='')
    {/*{{{*/
        if(isset($this->_route_params[$name]))
        {
            return $this->_route_params[$name];
        }
        if('' != $this->_ext_params[$name])
        {
            return $this->_ext_params[$name];
        }
        return $default;
    }/*}}}*/
}/*}}}*/
