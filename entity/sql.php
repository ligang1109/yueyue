<?php
namespace YueYue\Entity;

interface Sql
{/*{{{*/
    public function addSqlAttrs($gen_sql_attrs_value=true);
    public function getSqlUpdateFields($params=array());
    public function setAttrsBySqlItem($item=array());
}/*}}}*/
