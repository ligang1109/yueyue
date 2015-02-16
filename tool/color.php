<?php
/**
* @file color.php
* @brief color output
* @author ligang
* @version 1.0
* @date 2014-11-19
 */

namespace YueYue\Tool;

class Color
{/*{{{*/
    private static $_conf = array
    (/*{{{*/
        "black"   => "\033[01;0m",
        "red"     => "\033[01;31m",
        "green"   => "\033[01;32m",
        "yellow"  => "\033[01;33m",
        "blue"    => "\033[01;34m",
        "magenta" => "\033[01;35m",
        "cyan"    => "\033[01;36m",
        "white"   => "\033[01;37m",
    );/*}}}*/

    public static function addColor($str, $color)
    {/*{{{*/
        if(isset(self::$_conf[$color]))
        {
            $str = self::$_conf[$color].$str."\033[0m";
        }
        return $str;
    }/*}}}*/
}/*}}}*/
