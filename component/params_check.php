<?php
namespace YueYue\Component;

class ParamsCheck
{/*{{{*/
    public static function strNotNull($value)
    {/*{{{*/
        return ('' !== $value) ? true : false;
    }/*}}}*/
    public static function numNotZero($value)
    {/*{{{*/
        return (0 !== $value) ? true : false;
    }/*}}}*/
    public static function arrNotEmpty($value)
    {/*{{{*/
        return (is_array($value) && !empty($value)) ? true : false;
    }/*}}}*/
    public static function isMd5($value)
    {/*{{{*/
        return preg_match('/^[0-9a-f]{32}$/', $value) ? true : false;
    }/*}}}*/
    public static function isNum($value)
    {/*{{{*/
        return is_numeric($value) ? true : false;
    }/*}}}*/
}/*}}}*/
