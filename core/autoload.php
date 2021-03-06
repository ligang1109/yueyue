<?php
/**
* @file autoload.php
* @brief autoload for yueyue
* @author ligang
* @version 1.0
* @date 2014-10-29
 */

namespace YueYue\Core;

class Autoload
{/*{{{*/
    private static $_key      = '';
    private static $_src_root = '';
    private static $_special_paths = array();

    /**
        * @brief must called first
        *
        * @param $key
        * @param $src_root
        *
        * @return 
     */
    public static function init($key, $src_root)
    {/*{{{*/
        self::$_key      = $key;
        self::$_src_root = $src_root;

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }/*}}}*/

    /**
        * @brief special path such as config
        *
        * @param $key
        * @param $special_src_root
        *
        * @return 
     */
    public static function setSpecialPath($key, $special_src_root)
    {/*{{{*/
        self::$_special_paths[$key] = $special_src_root;
    }/*}}}*/

    /**
        * @brief implement autoload
        *
        * @param $search_cls_name
        *
        * @return 
     */
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

        preg_match_all('/([A-Z][a-z0-9_]+)/', $cls_name, $matches);
        $name_data = array();
        foreach($matches[1] as $item)
        {
            $name_data[] = strtolower($item);
        }

        $cls_path.= implode('_', $name_data).'.php';
        if(!file_exists($cls_path))
        {
            throw new \YueYue\Component\Exception(\YueYue\Knowledge\Errno::E_SYS_CLS_NOT_EXISTS, "cls file $cls_path not exists");
        }

        include($cls_path);
	}/*}}}*/
}/*}}}*/
