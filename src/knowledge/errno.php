<?php
namespace YueYue\Knowledge;

class Errno
{/*{{{*/
    const SUCCESS = 0;

    const E_SYS_INVALID_TPL_ENGINE = 11;

    private static $_error_msg_def = array
    (/*{{{*/
        self::E_SYS_INVALID_TPL_ENGINE => 'invalid tpl engine',
    );/*}}}*/

    public static function getErrorMsg($errno)
    {/*{{{*/
        return array_key_exists($errno, self::$_error_msg_def) ? self::$_error_msg_def[$errno] : '';
    }/*}}}*/
}/*}}}*/
