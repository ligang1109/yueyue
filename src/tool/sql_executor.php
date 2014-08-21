<?php
namespace YueYue\Tool;

class SqlExecutor
{/*{{{*/
    const CONN_LONG  = true;
    const CONN_SHORT = false;

	const DEF_CHARSET = 'UTF8';

    private $_db_conf = array();
    private $_dbh     = null;

    public function __construct($db_conf)
    {/*{{{*/
        $this->_initDBConf($db_conf);
        $this->_connect();
    }/*}}}*/

    public function query($sql, $values=array())
    {/*{{{*/
        $this->_logSql($sql,$values);

		$exec_result = $this->_execute($sql, $values);
		$sth         = $exec_result['sth'];
		$ret         = $exec_result['ret'];
        if($ret)
        {
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            if(is_array($result) && array_key_exists(0, $result))
            {
            	return $result[0];
            }
        }

        return null;
    }/*}}}*/
    public function querys($sql, $values=array())
    {/*{{{*/
        $this->_logSql($sql,$values);

		$exec_result = $this->_execute($sql, $values);
		$sth         = $exec_result['sth'];
		$ret         = $exec_result['ret'];
        if($ret)
        {
            return $sth->fetchAll( \PDO::FETCH_ASSOC );
        }
        return array();
    }/*}}}*/
    public function exeNoQuery($sql, $values=array())
    {/*{{{*/
        $this->_logSql($sql,$values);

		$exec_result = $this->_execute($sql, $values);
		$sth         = $exec_result['sth'];
		$ret         = $exec_result['ret'];
        if($ret)
        {
			return $sth->rowCount();
        }
		return false;
    }/*}}}*/
    public function execute($sql, $values=array())
    {/*{{{*/
        $this->_logSql($sql,$values);

		$exec_result = $this->_execute($sql, $values);
        return $exec_result['ret'];
    }/*}}}*/

    public function beginTrans()
    {/*{{{*/
        $this->_dbh->beginTransaction();
    }/*}}}*/
    public function commit()
    {/*{{{*/
        return $this->_dbh->commit();
    }/*}}}*/
    public function rollback()
    {/*{{{*/
        return $this->_dbh->rollback();
    }/*}}}*/

    public function getLastInsertID()
    {/*{{{*/
        return $this->_dbh->lastInsertId();
    }/*}}}*/


    private function _formatValues($values)
    {/*{{{*/
        $result = array();
        foreach($values as $k => $v)
        {
        	if(is_string($v))
        	{
        		$result[$k] = "'".$v."'";
        		continue;
        	}
        	if(is_null($v))
        	{
        		$result[$k] = 'null';
        	}
        	$result[$k] = $v;
        }
        return $result;
    }/*}}}*/

    private function _logSql($sql, $values=array())
    {/*{{{*/
    	if(empty($values))
    	{
            \YueYue\Component\Logger::log('sql', $sql);
    		return;
    	}

    	$str = str_replace('%', '{#}', $sql);
        $str = vsprintf(str_replace('?', '%s', $str), $this->_formatValues($values));
        $str = str_replace('{#}', '%', $str);

        \YueYue\Component\Logger::log('sql', $str);
    }/*}}}*/

    private function _initDBConf($db_conf)
    {/*{{{*/
        $this->_db_conf = array(
            'host'    => $db_conf['host'],
            'user'    => $db_conf['user'],
            'pass'    => $db_conf['pass'],
            'name'    => $db_conf['name'],
            'port'    => $db_conf['port'],
            'ctype'   => isset($db_conf['ctype']) ? $db_conf['ctype'] : self::CONN_SHORT,
            'charset' => isset($db_conf['charset']) ? $db_conf['charset'] : self::DEF_CHARSET,
        );
    }/*}}}*/

    private function _connect()
    {/*{{{*/
        $dsn = 'mysql:host='.$this->_db_conf['host'].';dbname='.$this->_db_conf['name'];
        if( !is_null( $this->_db_conf['port'] ) )
        {
            $dsn.= ';port='.$this->_db_conf['port'];
        }
        try
        {
            $this->_dbh = new \PDO($dsn, $this->_db_conf['user'], $this->_db_conf['pass'],
                array(\PDO::ATTR_PERSISTENT => $this->_db_conf['ctype']));
        }
        catch(\PDOException $e)
        {
            if(\YueYue\Knowledge\Pdo::lostConnection($e))
            {
                $this->_dbh = new \PDO($dsn, $this->_db_conf['user'], $this->_db_conf['pass'],
                    array(\PDO::ATTR_PERSISTENT => $this->_db_conf['ctype']));
            }
            else
            {
                throw $e;
            }
        }
        $this->_dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->_dbh->query('SET NAMES '.$this->_db_conf['charset']);
    }/*}}}*/
    private function _reconnect()
    {/*{{{*/
        $this->_dbh = null;
        $this->_connect();
    }/*}}}*/

	private function _execute($sql, $values)
	{/*{{{*/
		$sth = $this->_prepareExecute($sql, $values);
		try
		{
			$ret = $sth->execute();
		}
        catch(\PDOException $e)
        {
            if(!\YueYue\Knowledge\Pdo::goneAway($e))
            {
                throw $e;
            }

            $this->_reconnect();
			$sth = $this->_prepareExecute($sql, $values);
			$ret = $sth->execute();
		}

		return array(
			'sth' => $sth,
			'ret' => $ret,
		);
	}/*}}}*/
	private function _prepareExecute($sql, $values)
	{/*{{{*/
        $i   = 0;
        $sth = $this->_dbh->prepare($sql);

        if(!empty($values))
        {
	        foreach($values as $value)
	        {
	            $sth->bindValue(++$i, $value);
	        }
        }
		return $sth;
	}/*}}}*/
}/*}}}*/
