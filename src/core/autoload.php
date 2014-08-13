<?php
namespace YueYue\Core;

class Autoload
{/*{{{*/
    private static $_key      = '';
    private static $_src_root = '';

    public static function init($key, $src_root)
    {/*{{{*/
        self::$_key      = $key;
        self::$_src_root = $src_root;

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }/*}}}*/
	public static function autoload($cls_name)
	{/*{{{*/
        $cls_name = trim($cls_name, '\\');
        $dir_data = explode('\\', $cls_name);
        if(self::$_key != array_shift($dir_data))
        {
            return ;
        }

        $cls_name = array_pop($dir_data);
        $cls_path = self::$_src_root;
        foreach($dir_data as $item)
        {
            $cls_path.= strtolower($item).'/';
        }

        preg_match_all('/([A-Z][a-z0-9]+)/', $cls_name, $matches);
        $name_data = array();
        foreach($matches[1] as $item)
        {
            $name_data[] = strtolower($item);
        }

        $cls_path.= implode('_', $name_data).'.php';
        include($cls_path);
	}/*}}}*/
}/*}}}*/


\YueYue\Core\Autoload::init('YueYue', __DIR__.'/../');
