<?php
namespace YueYue\Knowledge;

class Sql
{/*{{{*/
    const QUERY_COND_METHOD_EQUAL     = 1;
    const QUERY_COND_METHOD_LIKE      = 2;
    const QUERY_COND_METHOD_IN        = 3;
    const QUERY_COND_METHOD_NOT_IN    = 4;
    const QUERY_COND_METHOD_NOT_EQUAL = 5;

    const QUERY_COND_LOGIC_AND = 'and';
    const QUERY_COND_LOGIC_OR  = 'or';

    const QUERY_COND_IN_COND     = 'in';
    const QUERY_COND_NOT_IN_COND = 'not in';
}/*}}}*/
