<?php
/**
* @file loader.php
* @brief component loader use for load singleton
* @author ligang
* @version 1.0
* @date 2014-10-29
 */

namespace YueYue\Component;

class Loader
{/*{{{*/
    /**
        * @brief implement singleton
        *
        * @param $cls_name
        * @param $construct_params
        * @param $key
        *
        * @return 
     */
	public static function loadSingleton($cls_name, $construct_params=null, $key='')
	{/*{{{*/
        if('' == $key)
        {
            $key = $cls_name;
        }
        $obj = \YueYue\Component\ObjContainer::find($key);
        if(!is_object($obj))
        {
			$obj = is_null($construct_params) ? new $cls_name() : new $cls_name($construct_params);
			\YueYue\Component\ObjContainer::add($obj, $key);
        }

		return $obj;
	}/*}}}*/

    /**
        * @brief yueyue singleton
        *
        * @return 
     */
    public static function loadYueYue()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Core\Yueyue');
    }/*}}}*/

    /**
        * @brief router singleton
        *
        * @return 
     */
    public static function loadRouter()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Route\Router');
    }/*}}}*/

    /**
        * @brief request singleton
        *
        * @return 
     */
    public static function loadRequest()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Component\Request');
    }/*}}}*/

    /**
        * @brief response singleton
        *
        * @return 
     */
    public static function loadResponse()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Component\Response');
    }/*}}}*/

    /**
        * @brief controller singleton
        *
        * @param $controller_namespace
        * @param $controller_name
        *
        * @return 
     */
    public static function loadController($controller_namespace, $controller_name)
    {/*{{{*/
        $cls_name = $controller_namespace.'\\'.ucfirst($controller_name);
        return self::loadSingleton($cls_name, $controller_name);
    }/*}}}*/

    /**
        * @brief view singleton by tpl_engine
        *
        * @param $tpl_engine
        *
        * @return 
     */
    public static function loadView($tpl_engine)
    {/*{{{*/
        $cls_name = '';
        switch($tpl_engine)
        {
        case \YueYue\Knowledge\Tpl::ENGINE_PHP:
            $cls_name = '\YueYue\View\Php';
            break;
        case \YueYue\Knowledge\Tpl::ENGINE_SMARTY:
            $cls_name = '\YueYue\View\Smarty';
            break;
        default:
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_COMPONENTS_VIEW_INVALID_TPL_ENGINE);
        }

        return self::loadSingleton($cls_name);
    }/*}}}*/

    /**
        * @brief sql_executor singleton
        *
        * @param $db_conf
        *
        * @return 
     */
    public static function loadSqlExecutor($db_conf)
    {/*{{{*/
        return self::loadSingleton('\YueYue\Tool\SqlExecutor', $db_conf);
    }/*}}}*/

    /**
        * @brief task_runner singleton
        *
        * @return 
     */
    public static function loadTaskRunner()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Task\Runner');
    }/*}}}*/
}/*}}}*/
