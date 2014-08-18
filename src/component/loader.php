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

    public static function loadRequest()
    {/*{{{*/
        return self::loadSingleton('\YueYue\Component\Request');
    }/*}}}*/
    public static function loadWebController($controller_name, $controller_namespace)
    {/*{{{*/
        $cls_name = $controller_namespace.'\\'.ucfirst($controller_name);
        return self::loadSingleton($cls_name, $controller_name);
    }/*}}}*/
}/*}}}*/
