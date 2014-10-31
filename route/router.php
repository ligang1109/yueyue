<?php
/**
* @file router.php
* @brief router
* @author ligang
* @version 1.0
* @date 2014-10-29
 */

namespace YueYue\Route;

class Router
{/*{{{*/
    const DEF_ROUTE = '\YueYue\Route\General';

    private $_general_table = array();
    private $_regular_table = array();

    /**
        * @brief add general route, match uri use equal
        *
        * @return 
     */
    public function addGeneralRoute($uri, $route, $params=array())
    {/*{{{*/
        $this->_general_table[$uri] = array(
            'route'  => $route,
            'params' => $params,
        );
    }/*}}}*/

    /**
        * @brief add regular route, match uri use regular
        *
        * @return 
     */
    public function addRegularRoute($pattern, $route, $params=array())
    {/*{{{*/
        $this->_regular_table[] = array(
            'pattern' => $pattern,
            'route'   => $route,
            'params'  => $params,
        );
    }/*}}}*/

    /**
        * @brief find route
        *
        * @return 
     */
    public function findRoute()
    {/*{{{*/
        $uri        = $this->_parseUri();
        $route_conf = $this->_getRouteConf($uri);

        return $this->_loadRoute($route_conf['route'], $uri, $route_conf['params']);
    }/*}}}*/


    private function _parseUri()
    {/*{{{*/
        if(empty($_SERVER['QUERY_STRING']))
        {
            return $_SERVER['REQUEST_URI'];
        }

        preg_match('/^([^?]+)/', $_SERVER['REQUEST_URI'], $matches);
        return $matches[1];
    }/*}}}*/
    private function _getRouteConf($uri)
    {/*{{{*/
        $route  = self::DEF_ROUTE;
        $params = array();
        if(isset($this->_general_table[$uri]))
        {
            $route  = $this->_general_table[$uri]['route'];
            $params = $this->_general_table[$uri]['params'];
        }
        else
        {
            foreach($this->_regular_table as $item)
            {
                if(preg_match($item['pattern'], $uri))
                {
                    $route  = $item['route'];
                    $params = $item['params'];
                }
            }
        }

        return array(
            'route'  => $route,
            'params' => $params,
        );
    }/*}}}*/
    private function _loadRoute($route_cls, $uri, $params)
    {/*{{{*/
        try
        {
            $route = new $route_cls($uri, $params);
        }
        catch(\YueYue\Component\Exception $e)
        {
            if(\YueYue\Knowledge\Errno::E_SYS_CLS_NOT_EXISTS == $e->getCode())
            {
                throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_SYS_INVALID_ROUTE, "route $route_cls not exists");
            }
            throw $e;
        }
        if(!($route instanceof \YueYue\Route\Base))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_SYS_INVALID_ROUTE, "route $route_cls must extends base route");
        }

        return $route;
    }/*}}}*/
}/*}}}*/
