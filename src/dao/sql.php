<?php
namespace YueYue\Dao;

abstract class Sql
{/*{{{*/
    abstract public function setTableName($hash_value=null);

    abstract protected function _getQueryConf();

    protected $_entity_name = '';
    protected $_query_conf  = array();
    protected $_executor    = null;
    protected $_table_name  = '';

    public function __construct($entity_name)
    {/*{{{*/
        $this->_entity_name = $entity_name;
        $this->_query_conf  = $this->_getQueryConf();
    }/*}}}*/
    public function setExecutor($executor)
    {/*{{{*/
        $this->_executor = $executor;
    }/*}}}*/

    public function add($obj=null)
    {/*{{{*/
        if(is_null($obj) || !is_object($obj))
        {
            return false;
        }
        if($this->_addImp($obj))
        {
            return $obj;
        }
        return false;
    }/*}}}*/
    public function adds($objs=array())
    {/*{{{*/
        if(empty($objs) || !is_array($objs))
        {
            return false;
        }
        if($this->_addsImp($objs))
        {
            return $objs;
        }
        return false;
    }/*}}}*/
    public function getById($id, $fields=array())
    {/*{{{*/
        $sql = 'select '.$this->_makeFieldSql($fields).' from '.$this->_table_name.' ';
        $sql.= 'where id = ? ';

        $item = $this->_executor->query($sql, array($id));
        return empty($item) ? array() : $item;
    }/*}}}*/
    public function updateById($id, $fields)
    {/*{{{*/
        $sql_values = array();
        $sql = 'update '.$this->_table_name.' set ';
        foreach($fields as $col => $value)
        {
            $sql.= "$col = ?,";
            $sql_values[] = $value;
        }
        $sql_values[] = $id;
        $sql = rtrim($sql, ',');
        $sql.= ' where id = ? ';

        return $this->_executor->exeNoQuery($sql, $sql_values);
    }/*}}}*/
    public function delById($id)
    {/*{{{*/
        $sql = "delete from $this->_table_name where id = ?";
        return $this->_executor->exeNoQuery($sql, array($id));
    }/*}}}*/
    public function listByIds($ids, $cond, $fields=array())
    {/*{{{*/
        $sql = 'select '.$this->_makeFieldSql($fields).' ';
        $sql.= 'from '.$this->_table_name.' ';
        $sql.= 'where id '.$cond.' (';
        $tmp = array();
        foreach($ids as $index => $id)
        {
            $ids[$index] = intval($id);
            $tmp[] = '?';
        }
        $sql.= implode(',', $tmp);
        $sql.= ")";

        $data = $this->_executor->querys($sql, $ids);
        return empty($data) ? array() : $data;
    }/*}}}*/

    public function getMaxId()
    {/*{{{*/
        $sql = 'select max(id) from '.$this->_table_name;
        $item = $this->_executor->query($sql);

        return current($item);
    }/*}}}*/

    public function beginTrans()
    {/*{{{*/
        return $this->_executor->beginTrans();
    }/*}}}*/
    public function commit()
    {/*{{{*/
        return $this->_executor->commit();
    }/*}}}*/
    public function rollback()
    {/*{{{*/
        return $this->_executor->rollback();
    }/*}}}*/

    protected function _makeSqlLimit($bgn, $cnt)
    {/*{{{*/
        return $cnt ? "$bgn, $cnt" : "";
    }/*}}}*/
    protected function _simpleQuery($query_key, $params, $fields=array(), $order_by='', $limit='', $cond_logic=\YueYue\Knowledge\Sql::QUERY_COND_LOGIC_AND)
    {/*{{{*/
        if(!array_key_exists($query_key, $this->_query_conf))
        {
            return false;
        }

        $sql_conf = $this->_makeSqlConf($this->_query_conf[$query_key], $params);

        $conds = empty($sql_conf['conds']) ? array() : $sql_conf['conds'];
        $sql   = $this->_makeSql($conds, $fields, $cond_logic, $order_by, $limit);

        $values = empty($sql_conf['values']) ? array() : $sql_conf['values'];
        $data   = $this->_executor->querys($sql, $values);

        return empty($data) ? array() : $data;
    }/*}}}*/
    protected function _simpleQueryCnt($query_key, $params, $cond_logic=\YueYue\Knowledge\Sql::QUERY_COND_LOGIC_AND)
    {/*{{{*/
        if(!array_key_exists($query_key, $this->_query_conf))
        {
            return false;
        }

        $sql_conf = $this->_makeSqlConf($this->_query_conf[$query_key], $params);

        $conds = empty($sql_conf['conds']) ? array() : $sql_conf['conds'];
        $sql   = $this->_makeCntSql($conds, $cond_logic);

        $values = empty($sql_conf['values']) ? array() : $sql_conf['values'];
        $item   = $this->_executor->query($sql, $values);

        return current($item);
    }/*}}}*/


    private function _addImp($obj)
    {/*{{{*/
        $cols = array_keys($obj->toAry());
        $vals = array_values($obj->toAry());
        $hold = array_fill(0, count($cols), '?');

        $sql = 'insert '.$this->_table_name.' ';
        $sql.= '( '.implode(", ", $cols).' ) ';
        $sql.= 'values ';
        $sql.= '( '.implode(", ", $hold).' ); ';

        return $this->_executor->exeNoQuery($sql, $vals);
    }/*}}}*/
    private function _addsImp($objs)
    {/*{{{*/
        $cols = array_keys($objs[0]->toAry());
        $hold = array_fill(0, count($cols), '?');
        $vals = array();
        foreach($objs as $obj)
        {
            $vals = array_merge($vals, array_values($obj->toAry()));
        }
        $len = count($objs);
        $sql = 'insert '.$this->_table_name.' ';
        $sql.= '( '.implode(", ", $cols).' ) ';
        $sql.= 'values ';
        for($i = 0; $i < $len; $i++)
        {
            $sql.= '( '.implode(", ", $hold).' ), ';
        }
        $sql = rtrim($sql, ', ').';';
        return $this->_executor->exeNoQuery($sql, $vals);
    }/*}}}*/

    private function _makeSqlConf($col_conf, $params)
    {/*{{{*/
        $result = array(
            'conds'  => array(),
            'values' => array(),
        );
        foreach($col_conf as $col => $method)
        {
            if(array_key_exists($col, $params))
            {
                $value    = $params[$col];
                $sql_cond = $this->_makeSqlCond($col, $method, $value);
                if(false !== $sql_cond)
                {
                    $result['conds'][]  = $sql_cond['cond'];
                    if(is_array($sql_cond['value']))
                    {
                        $result['values'] = array_merge($result['values'], $sql_cond['value']);
                    }
                    else
                    {
                        $result['values'][] = $sql_cond['value'];
                    }
                }
            }
        }
        return $result;
    }/*}}}*/
    private function _makeSqlCond($col, $method, $value)
    {/*{{{*/
        $result = array(
            'cond'  => '',
            'value' => '',
        );

        switch($method)
        {
        case \YueYue\Knowledge\Sql::QUERY_COND_METHOD_EQUAL:
            $result['cond']  = "$col = ?";
            $result['value'] = $value;
            break;
        case \YueYue\Knowledge\Sql::QUERY_COND_METHOD_LIKE:
            $result['cond']  = "$col like ?";
            $result['value'] = "%$value%";
            break;
        case \YueYue\Knowledge\Sql::QUERY_COND_METHOD_IN:
            $cond_value      = $this->_fmtSqlCondInCondValue($col, $value);
            $result['cond']  = $cond_value['cond'];
            $result['value'] = $cond_value['value'];
            break;
        case \YueYue\Knowledge\Sql::QUERY_COND_METHOD_NOT_IN:
            $cond_value      = $this->_fmtSqlCondInCondValue($col, $value, \YueYue\Knowledge\Sql::QUERY_COND_NOT_IN_COND);
            $result['cond']  = $cond_value['cond'];
            $result['value'] = $cond_value['value'];
            break;
        case \YueYue\Knowledge\Sql::QUERY_COND_METHOD_NOT_EQUAL:
            $result['cond']  = "$col != ?";
            $result['value'] = $value;
            break;
        default:
            $result = false;
        }
        return $result;
    }/*}}}*/
    private function _makeSql($conds, $fields, $cond_logic, $order_by, $limit)
    {/*{{{*/
        $result = "select ".$this->_makeFieldSql($fields)." from $this->_table_name ";
        if(!empty($conds))
        {
            $result.= "where ".implode(" $cond_logic ", $conds);
        }
        if('' !== $order_by)
        {
            $result.= " order by $order_by ";
        }
        if('' !== $limit)
        {
            $result.= " limit $limit ";
        }
        return $result;
    }/*}}}*/
    private function _makeCntSql($conds, $cond_logic)
    {/*{{{*/
        $result = "select count(*) from $this->_table_name ";
        if(!empty($conds))
        {
            $result.= "where ".implode(" $cond_logic ", $conds);
        }
        return $result;
    }/*}}}*/
    private function _fmtSqlCondInCondValue($col, $value, $cond=\YueYue\Knowledge\Sql::QUERY_COND_IN_COND)
    {/*{{{*/
        $sql = "$col $cond (";
        $tmp = array();
        foreach($value as $k => $v)
        {
            if(is_numeric($v))
            {
                $v = intval($v);
            }
            $value[$k] = $v;
            $tmp[] = '?';
        }
        $sql.= implode(',', $tmp);
        $sql.= ")";

        return array(
            'cond'  => $sql,
            'value' => $value,
        );
    }/*}}}*/
	private function _makeFieldSql($fields)
	{/*{{{*/
		return empty($fields) ? '*' : implode(', ', $fields);
	}/*}}}*/
}/*}}}*/
