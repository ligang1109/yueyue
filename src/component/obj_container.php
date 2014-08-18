<?php
namespace YueYue\Component;

class ObjContainer
{/*{{{*/
    private static $_objs = array();
    
    public static function add($obj, $key='')
    {/*{{{*/
        if(!is_object($obj))
        {
            return false;
        }

        if('' == $key)
        {
            $key = get_class($obj);
        }
        self::$_objs[$key] = $obj;

        return true;
    }/*}}}*/
    public static function find($key)
    {/*{{{*/
        return self::have($key) ? self::$_objs[$key] : null;
    }/*}}}*/
    public static function have($key)
    {/*{{{*/
        return array_key_exists($key, self::$_objs) ? true : false;
    }/*}}}*/
}/*}}}*/
