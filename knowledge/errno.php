<?php
/**
* @file errno.php
* @brief errno
* @author ligang
* @version 1.0
* @date 2014-10-30
 */

namespace YueYue\Knowledge;

class Errno
{/*{{{*/
    const SUCCESS = 0;

    const E_SYS_CLS_NOT_EXISTS      = 11;
    const E_SYS_INVALID_ROUTE       = 12;
    const E_SYS_INVALID_CONTROLLER  = 13;
    const E_SYS_INVALID_REQUEST_URI = 14;

    const E_COMPONENTS_CONTROLLER_NOT_EXISTS      = 101;
    const E_COMPONENTS_ACTION_NOT_EXISTS          = 102;
    const E_COMPONENTS_VIEW_INVALID_TPL_ENGINE    = 103;
    const E_COMPONENTS_RESPONSE_INVALID_FMT_VALUE = 104;

    const E_SVC_SERVE_NOT_EXISTS = 201;

    const E_TASK_INVALID_ARGS      = 301;
    const E_TASK_INVALID_CMD       = 302;
    const E_TASK_INVALID_TASK_NAME = 303;
    const E_TASK_INVALID_TASK_CLS  = 304;

    private static $_error_msg_def = array
    (/*{{{*/
    );/*}}}*/

    public static function getErrorMsg($errno)
    {/*{{{*/
        return array_key_exists($errno, self::$_error_msg_def) ? self::$_error_msg_def[$errno] : '';
    }/*}}}*/
}/*}}}*/
