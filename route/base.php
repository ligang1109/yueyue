<?php
/**
* @file base.php
* @brief route base
* @author ligang
* @version 1.0
* @date 2014-10-30
 */

namespace YueYue\Route;

abstract class Base
{/*{{{*/
    protected $_request_uri  = '';
    protected $_route_params = array();
    protected $_request      = null;

    /**
        * @brief go route
        *
        * @param $params
        *
        * @return 
     */
    abstract public function go($ext_params=array());

    public function __construct($uri, $params=array())
    {/*{{{*/
        $this->_request_uri  = $uri;
        $this->_route_params = $params;
        $this->_request      = \YueYue\Component\Loader::loadRequest();
    }/*}}}*/
}/*}}}*/
