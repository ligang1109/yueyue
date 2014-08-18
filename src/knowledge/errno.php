<?php
namespace YueYue\Knowledge;

class Errno
{/*{{{*/
    const SUCCESS = 0;

    private static $_error_msg_def = array
    (/*{{{*/
    );/*}}}*/

    public static function getErrorMsg($errno)
    {/*{{{*/
        return array_key_exists($errno, self::$_error_msg_def) ? self::$_error_msg_def[$errno] : '';
    }/*}}}*/
}/*}}}*/
