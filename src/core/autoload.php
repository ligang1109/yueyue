<?php
namespace YueYue\Core;

class Autoload
{/*{{{*/
    private static $_key      = '';
    private static $_src_root = '';
    private static $_special_paths = array();

    public static function init($key, $src_root)
    {/*{{{*/
        self::$_key      = $key;
        self::$_src_root = $src_root;

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }/*}}}*/
    public static function setSpecialPath($key, $special_src_root)
    {/*{{{*/
        self::$_special_paths[$key] = $special_src_root;
    }/*}}}*/
	public static function autoload($search_cls_name)
	{/*{{{*/
        $cls_name = trim($search_cls_name, '\\');
        $dir_data = explode('\\', $cls_name);
        if(self::$_key != array_shift($dir_data))
        {
            return ;
        }

        $cls_name = array_pop($dir_data);
        $cls_key  = array_shift($dir_data);
        $cls_path = isset(self::$_special_paths[$cls_key]) ? self::$_special_paths[$cls_key] : self::$_src_root;
        $cls_path.= strtolower($cls_key).'/';
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
        if(!file_exists($cls_path))
        {
            var_dump($cls_path, $search_cls_name);
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_SYS_CLS_NOT_EXISTS, "cls file $cls_path not exists");
        }

        include($cls_path);
	}/*}}}*/
}/*}}}*/
