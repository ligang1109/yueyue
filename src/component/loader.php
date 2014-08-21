<?php
namespace YueYue\Component;

class Loader
{/*{{{*/
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

    public static function loadYueYue()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Core\Yueyue');
    }/*}}}*/
    public static function loadRequest()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Component\Request');
    }/*}}}*/
    public static function loadResponse()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Component\Response');
    }/*}}}*/
    public static function loadController($controller_namespace, $controller_name)
    {/*{{{*/
        $cls_name = $controller_namespace.'\\'.ucfirst($controller_name);
        return self::loadSingleton($cls_name, $controller_name);
    }/*}}}*/
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
    public static function loadSqlExecutor($db_conf)
    {/*{{{*/
        return self::loadSingleton('\YueYue\Tool\SqlExecutor', $db_conf);
    }/*}}}*/
}/*}}}*/
