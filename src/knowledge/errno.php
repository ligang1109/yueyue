<?php
namespace YueYue\Knowledge;

class Errno
{/*{{{*/
    const SUCCESS = 0;

    const E_VIEW_INVALID_TPL_ENGINE = 101;

    const E_RESPONSE_INVALID_FMT_VALUE = 201;

    private static $_error_msg_def = array
    (/*{{{*/
        self::E_VIEW_INVALID_TPL_ENGINE    => 'invalid tpl engine',
        self::E_RESPONSE_INVALID_FMT_VALUE => 'invalid fmt value',
    );/*}}}*/

    public static function getErrorMsg($errno)
    {/*{{{*/
        return array_key_exists($errno, self::$_error_msg_def) ? self::$_error_msg_def[$errno] : '';
    }/*}}}*/
}/*}}}*/
