<?php
//defined('INC_YES') or exit('Access Denied');

/**
* Mysql 数据库类，支持Cache功能
*/

class cls_mysql
{
	/**
	* MySQL 连接标识
	* @var resource
	*/
	var $connid;

	/**
	* 整型变量用来计算被执行的sql语句数量
	* @var int
	*/
	var $querynum = 0;
	var $record;

	/**
	* 数据库连接，返回数据库连接标识符
	* @param string 数据库服务器主机
	* @param string 数据库服务器帐号
	* @param string 数据库服务器密码
	* @param string 数据库名
	* @param bool 是否保持持续连接，1为持续连接，0为非持续连接
	* @return link_identifier
	*/
	function cls_mysql($dbhost,$dbuser,$dbpw,$dbname,$charset = 'utf8') 
	{
		$dbhost = $dbhost;
		$dbuser = $dbuser;
		$dbpw   = $dbpw;
		$dbname = $dbname;
		$func   = 'mysql_connect' ;
		//$func = $pconnect == 1 ? 'mysql_pconnect' : 'mysql_connect';
		if(!$this->connid = @$func($dbhost, $dbuser, $dbpw))
		{
			$this->halt('Can not connect to MySQL server');
		}
		// 当mysql版本为4.1以上时，启用数据库字符集设置
		if($this->version() > '4.1' && $charset)
        {
			mysql_query("SET NAMES '".$charset."'" , $this->connid);
		}
		// 当mysql版本为5.0以上时，设置sql mode
		if($this->version() > '5.0') 
		{
			mysql_query("SET sql_mode=''" , $this->connid);
		}
		if($dbname) 
		{
			if(!@mysql_select_db($dbname , $this->connid))
			{
				$this->halt('Cannot use database '.$dbname);
			}
		}
		return $this->connid;
	}

	/**
	* 选择数据库
	* @param string 数据库名
	*/
	function select_db($dbname) 
	{
		return mysql_select_db($dbname , $this->connid);
	}

	/**
	* 执行sql语句
	* @param string sql语句
	* @param string 默认为空，可选值为 CACHE UNBUFFERED
	* @param int Cache以秒为单位的生命周期
	* @return resource
	*/
	function query($sql , $type = '' , $expires = 3600, $dbname = '') 
	{
		$func = $type == 'UNBUFFERED' ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql , $this->connid)) && $type != 'SILENT')
		{
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		return $query;
	}
	
	function escape_string($unescaped_string)
    {
        if (PHP_VERSION >= '4.3')
        {
            return mysql_real_escape_string($unescaped_string);
        }
        else
        {
            return mysql_escape_string($unescaped_string);
        }
    }
	
	/**
	* 执行sql语句，只得到一条记录
	* @param string sql语句
	* @param string 默认为空，可选值为 CACHE UNBUFFERED
	* @param int Cache以秒为单位的生命周期
	* @return array
	*/
	function get_one($sql, $type = '', $expires = 3600, $dbname = '')
	{
		$query = $this->query($sql, $type, $expires, $dbname);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		return $rs ;
	}
	
	/* 执行SQL语句 只得到一条记录 返回第一个字段的值 */
	function get_row($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false)
        {
            $row = mysql_fetch_row($res);

            if ($row !== false)
            {
                return $row[0];
            }
            else
            {
                return '';
            }
        }
        else
        {
            return false;
        }
    }
	
	function getAll($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_assoc($res))
            {
                $arr[] = $row;
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }
	/**
	* 从结果集中取得一行作为关联数组
	* @param resource 数据库查询结果资源
	* @param string 定义返回类型
	* @return array
	*/
	function fetch_array($query, $result_type = MYSQL_ASSOC) 
	{
		return mysql_fetch_array($query, $result_type);
	}

	function fetch_assoc($query)
	{	
		while ($row = mysql_fetch_assoc($query)) {
			$arr[] = $row;
		}
		return $arr;
	}
	
	function selectLimit($sql, $num, $start = 0)
    {
        if ($start == 0)
        {
            $sql .= ' LIMIT ' . $num;
        }
        else
        {
            $sql .= ' LIMIT ' . $start . ', ' . $num;
        }

        return $this->query($sql);
    }
	
	function get_col($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_row($res))
            {
                $arr[] = $row[0];
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }
	
	/**
	* 取得前一次 MySQL 操作所影响的记录行数
	* @return int
	*/
	function affected_rows() 
	{
		return mysql_affected_rows($this->connid);
	}

	/**
	* 取得结果集中行的数目
	* @return int
	*/
	function num_rows($query) 
	{
		return mysql_num_rows($query);
	}

	/**
	* 返回结果集中字段的数目
	* @return int
	*/
	function num_fields($query) 
	{
		return mysql_num_fields($query);
	}

    /**
	* @return array
	*/
	function result($query, $row) 
	{
		return @mysql_result($query, $row);
	}

	function free_result($query) 
	{
		return mysql_free_result($query);
	}

	/**
	* 取得上一步 INSERT 操作产生的 ID 
	* @return int
	*/
	function insert_id() 
	{
		return mysql_insert_id($this->connid);
	}

    /**
	* @return array
	*/
	function fetch_row($query) 
	{
		return mysql_fetch_row($query);
	}

    /**
	* @return string
	*/
	function version() 
	{
		return mysql_get_server_info($this->connid);
	}

	function close() 
	{
		return mysql_close($this->connid);
	}

    /**
	* @return string
	*/
	function error()
	{
		return @mysql_error($this->connid);
	}

    /**
	* @return int
	*/
	function errno()
	{
		return intval(@mysql_errno($this->connid)) ;
	}

    /**
	* 显示mysql错误信息
	*/
	function halt($message = '', $sql = '')
	{
		exit("MySQL Query:$sql <br> MySQL Error:".$this->error()." <br> MySQL Errno:".$this->errno()." <br> Message:$message");
	}
	
	function autoExecute($table, $field_values, $mode = 'INSERT', $where = '', $querymode = '')
    {
        $field_names = $this->get_col('DESC ' . $table);

        $sql = '';
        if ($mode == 'INSERT')
        {
            $fields = $values = array();
            foreach ($field_names AS $value)
            {
                if (array_key_exists($value, $field_values) == true)
                {
                    $fields[] = $value;
                    $values[] = "'" . $field_values[$value] . "'";
                }
            }

            if (!empty($fields))
            {
                $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
            }
        }
        else
        {
            $sets = array();
            foreach ($field_names AS $value)
            {
                if (array_key_exists($value, $field_values) == true)
                {
                    $sets[] = $value . " = '" . $field_values[$value] . "'";
                }
            }

            if (!empty($sets))
            {
                $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $sets) . ' WHERE ' . $where;
            }
        }

        if ($sql)
        {
            return $this->query($sql, $querymode);
        }
        else
        {
            return false;
        }
    }
	/**
	* 插入及更新数据
	*/
	function autoReplace($table, $field_values, $update_values, $where = '', $querymode = '')
    {
        $field_descs = $this->getAll('DESC ' . $table);

        $primary_keys = array();
        foreach ($field_descs AS $value)
        {
            $field_names[] = $value['Field'];
            if ($value['Key'] == 'PRI')
            {
                $primary_keys[] = $value['Field'];
            }
        }

        $fields = $values = array();
        foreach ($field_names AS $value)
        {
            if (array_key_exists($value, $field_values) == true)
            {
                $fields[] = $value;
                $values[] = "'" . $field_values[$value] . "'";
            }
        }

        $sets = array();
        foreach ($update_values AS $key => $value)
        {
            if (array_key_exists($key, $field_values) == true)
            {
                if (is_int($value) || is_float($value))
                {
                    $sets[] = $key . ' = ' . $key . ' + ' . $value;
                }
                else
                {
                    $sets[] = $key . " = '" . $value . "'";
                }
            }
        }

        $sql = '';
        if (empty($primary_keys))
        {
            if (!empty($fields))
            {
                $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
            }
        }
        else
        {
            if ($this->version() >= '4.1')
            {
                if (!empty($fields))
                {
                    $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
                    if (!empty($sets))
                    {
                        $sql .=  'ON DUPLICATE KEY UPDATE ' . implode(', ', $sets);
                    }
                }
            }
            else
            {
                if (empty($where))
                {
                    $where = array();
                    foreach ($primary_keys AS $value)
                    {
                        if (is_numeric($value))
                        {
                            $where[] = $value . ' = ' . $field_values[$value];
                        }
                        else
                        {
                            $where[] = $value . " = '" . $field_values[$value] . "'";
                        }
                    }
                    $where = implode(' AND ', $where);
                }

                if ($where && (!empty($sets) || !empty($fields)))
                {
                    if (intval($this->get_row("SELECT COUNT(*) FROM $table WHERE $where")) > 0)
                    {
                        if (!empty($sets))
                        {
                            $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $sets) . ' WHERE ' . $where;
                        }
                    }
                    else
                    {
                        if (!empty($fields))
                        {
                            $sql = 'REPLACE INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
                        }
                    }
                }
            }
        }

        if ($sql)
        {
            return $this->query($sql, $querymode);
        }
        else
        {
            return false;
        }
    }
}
?>