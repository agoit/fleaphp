<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 FleaPHP 项目的一部分
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 FLEA_Db_Driver_Mysql 驱动
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package DB
 * @version $Id: Mysql.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * 用于 mysql 扩展的数据库驱动程序
 *
 * @package DB
 */
class FLEA_Db_Driver_Mysql
{
    /**
     * 用于 genSeq()、dropSeq() 和 nextId() 的 SQL 查询语句
     */
    var $NEXT_ID_SQL    = "UPDATE %s SET ID = LAST_INSERT_ID(ID + 1)";
    var $CREATE_SEQ_SQL = "CREATE TABLE %s (id INT NOT NULL)";
    var $INIT_SEQ_SQL   = "INSERT INTO %s VALUES (%s)";
    var $DROP_SEQ_SQL   = "DROP TABLE %s";
    var $GET_ID_SQL     = "SELECT LAST_INSERT_ID()";

    /**
     * 用于描绘 true、false 和 null 的数据库值
     */
    var $TRUE_VALUE  = 1;
    var $FALSE_VALUE = 0;
    var $NULL_VALUE = 'NULL';

    /**
     * 用于获取元数据的 SQL 查询语句
     */
    var $META_COLUMNS_SQL = "SHOW COLUMNS FROM %s";

    /**
	 * 数据库连接信息
	 *
	 * @var array
	 */
	var $dsn = null;

	/**
	 * 数据库连接句柄
	 *
	 * @var resource
	 */
	var $conn = null;

	/**
	 * 所有 SQL 查询的日志
	 *
	 * @var array
	 */
	var $log = array();

	/**
	 * 最近一次插入操作或者 nextId() 操作返回的插入 ID
	 *
	 * @var mixed
	 */
	var $_insertId = null;

	/**
	 * 构造函数
	 *
	 * @param array $dsn
	 */
	function FLEA_Db_Driver_Mysql($dsn = false) {
	    $tmp = (array)$dsn;
	    unset($tmp['password']);
	    log_message('Construction FLEA_Db_Driver_Mysql(' . encode_url_args($tmp) . ')', 'debug');
	    $this->dsn = $dsn;
	}

    /**
     * 连接数据库
     *
     * @param array $dsn
     *
     * @return boolean
     */
    function connect($dsn = false) {
        if ($this->conn) { return true; }
        if (!$dsn) { $dsn = $this->dsn; }
        if (isset($dsn['port']) && $dsn['port'] != '') {
            $host = $dsn['host'] . ':' . $dsn['port'];
        } else {
            $host = $dsn['host'];
        }
        if (!isset($dsn['login'])) { $dsn['login'] = ''; }
        if (!isset($dsn['password'])) { $dsn['password'] = ''; }
        if (isset($dsn['options'])) {
            $this->conn = mysql_connect($host, $dsn['login'], $dsn['password'], false, $dsn['options']);
        } else {
            $this->conn = mysql_connect($host, $dsn['login'], $dsn['password']);
        }

        log_message("mysql_connect({$host}, {$dsn['login']}, ...)", 'debug');

        if (!$this->conn || !mysql_select_db($dsn['database'], $this->conn)) {
            load_class('FLEA_Db_Exception_SqlQuery');
            __THROW(new FLEA_Db_Exception_SqlQuery(
                "USE '{$dsn['database']}'", mysql_error($this->conn), mysql_errno($this->conn)
            ));
            return false;
        }

        $version = $this->getOne('SELECT VERSION()');
        if (isset($dsn['charset']) && $dsn['charset'] != '') {
            $charset = $dsn['charset'];
        } else {
            $charset = get_app_inf('databaseCharset');
        }
        if ($version >= '4.1' && $charset != '') {
            $this->_query("SET NAMES '" . $charset . "'");
        }

        return true;
    }

    /**
     * 关闭数据库连接
     */
    function close() {
        if (!$this->conn) {
            mysql_close($this->conn);
        }
        $this->_insertId = null;
        $this->conn = null;
    }

    /**
     * 执行一个查询，返回一个 resource 或者 boolean 值
     *
     * @param string $sql
     * @param array $inputarr
     * @param boolean $throw 指示查询出错时是否抛出异常
     *
     * @return resource|boolean
     */
    function execute($sql, $inputarr = null, $throw = true) {
        if (is_array($inputarr)) {
            $sql = $this->_prepareSql($sql, $inputarr);
        }
        return $this->_query($sql, $throw);
    }

    /**
     * 转义字符串
     *
     * @param string $value
     *
     * @return mixed
     */
    function qstr($value) {
        return "'" . mysql_real_escape_string($value, $this->conn) . "'";
    }

    /**
     * 将数据表名字转换为完全限定名
     *
     * @param string $tableName
     *
     * @return string
     */
    function qtable($tableName) {
        return '`' . $tableName . '`';
    }

    /**
     * 将字段名转换为标识符，避免因为字段名和数据库关键词相同导致的错误
     *
     * @param string $fieldName
     *
     * @return string
     */
    function qfield($fieldName) {
        return '`' . $fieldName . '`';
    }

    /**
     * 为数据表产生下一个序列值
     *
     * @param string $seqName
     *
     * @return int
     */
    function nextId($seqName = 'sdboseq') {
        $result = $this->_query(sprintf($this->NEXT_ID_SQL, $seqName), false);
        if ($result === false) {
            if (!$this->createSeq($seqName)) { return false; }
            $this->_query(sprintf($this->NEXT_ID_SQL, $seqName));
        }
        return $this->insertId();
    }

    /**
     * 创建一个新的序列，并返回第一个值
     *
     * @param string $seqName
     * @param int $startValue
     *
     * @return boolean
     */
    function createSeq($seqName = 'sdboseq', $startValue = 1) {
        if ($this->_query(sprintf($this->CREATE_SEQ_SQL, $seqName))) {
            return $this->_query(sprintf($this->INIT_SEQ_SQL,
                $seqName, $startValue - 1));
        } else {
            return false;
        }
    }

    /**
     * 删除一个序列
     *
     * 具体的实现与数据库系统有关。
     *
     * @param string $seqName
     */
    function dropSeq($seqName = 'sdboseq') {
        return $this->_query(sprintf($this->DROP_SEQ_SQL, $seqName));
    }

    /**
     * 获取自增字段的最后一个值
     *
     * @return mixed
     */
    function insertId() {
        $this->_insertId = $this->getOne($this->GET_ID_SQL);
        return $this->_insertId;
    }

    /**
     * 返回最近一次数据库操作受到影响的记录数
     *
     * @return int
     */
    function affectedRows() {
        return mysql_affected_rows($this->conn);
    }

    /**
     * 从记录集中返回一行数据
     *
     * @param resouce $res
     *
     * @return array
     */
    function fetchRow($res) {
        return mysql_fetch_row($res);
    }

    /**
     * 从记录集中返回一行数据，字段名作为键名
     *
     * @param resouce $res
     *
     * @return array
     */
    function fetchAssoc($res) {
        return mysql_fetch_assoc($res);
    }

    /**
     * 释放查询句柄
     *
     * @param resource $res
     *
     * @return boolean
     */
    function freeRes($res) {
        return mysql_free_result($res);
    }

    /**
     * 进行限定记录集的查询
     *
     * @param string $sql
     * @param int $length
     * @param int $offset
     *
     * @return resource
     */
    function selectLimit($sql, $length = null, $offset = null) {
        if ($offset !== null) {
            $sql .= ' LIMIT ' . (int)$offset;
            if ($length !== null) {
                $sql .= ', ' . (int)$length;
            } else {
                $sql .= ', 4294967294';
            }
        } elseif ($length !== null) {
            $sql .= ' LIMIT ' . (int)$length;
        }
        return $this->execute($sql);
    }

    /**
     * 执行一个查询，返回查询结果记录集
     *
     * @param string|resource $sql
     *
     * @return array
     */
    function getAll($sql) {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->_query($sql);
        }
        $data = array();
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysql_free_result($res);
        return $data;
    }

    /**
     * 执行一个查询，返回查询结果记录集，并按照指定字段分组
     *
     * @param string|resource $sql
     * @param string $groupField
     * $param boolean $oneToOne
     *
     * @return array
     */
    function getAllGroupBy($sql, $groupField, $oneToOne = false) {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->_query($sql);
        }
        $data = array();
        if ($oneToOne) {
            while ($row = mysql_fetch_assoc($res)) {
                $ref = $row[$groupField];
                $data[$ref] = $row;
            }
        } else {
            while ($row = mysql_fetch_assoc($res)) {
                $ref = $row[$groupField];
                $data[$ref][] = $row;
            }
        }
        mysql_free_result($res);
        return $data;
    }

    /**
     * 执行查询，返回第一条记录的第一个字段
     *
     * @param string|resource $sql
     *
     * @return mixed
     */
    function getOne($sql) {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->_query($sql);
        }
        $row = mysql_fetch_row($res);
        mysql_free_result($res);
        return isset($row[0]) ? $row[0] : null;
    }

    /**
     * 执行查询，返回第一条记录
     *
     * @param string|resource $sql
     *
     * @return mixed
     */
    function getRow($sql) {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->_query($sql);
        }
        $row = mysql_fetch_assoc($res);
        mysql_free_result($res);
        return $row;
    }

    /**
     * 执行查询，返回结果集的第一列
     *
     * @param string|resource $sql
     *
     * @return mixed
     */
    function getCol($sql) {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->_query($sql);
        }
        $data = array();
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = reset($row);
        }
        mysql_free_result($res);
        return $data;
    }

    /**
     * 返回指定表（或者视图）的元数据
     *
     * 部分代码参考 ADOdb 实现。
     *
     * 每个字段包含下列属性：
     *
     * name:            字段名
     * scale:           小数位数
     * type:            字段类型
     * simpleType:      简单字段类型（与数据库无关）
     * maxLength:       最大长度
     * notNull:         是否不允许保存 NULL 值
     * primaryKey:      是否是主键
     * autoIncrement:   是否是自动增量字段
     * binary:          是否是二进制数据
     * unsigned:        是否是无符号数值
     * hasDefault:      是否有默认值
     * defaultValue:    默认值
     *
     * @param string $table
     *
     * @return array
     */
    function metaColumns($table) {
        /**
         *	C 长度小于等于 250 的字符串
         *	X 长度大于 250 的字符串
         *	B 二进制数据
         * 	N 数值或者浮点数
         *	D 日期
         *	T TimeStamp
         * 	L 逻辑布尔值
         *	I 整数
         *  R 自动增量或计数器
    	 */
        static $typeMap = array(
            'BIT'           => 'I',
            'TINYINT'       => 'I',
            'BOOL'          => 'L',
            'BOOLEAN'       => 'L',
            'SMALLINT'      => 'I',
            'MEDIUMINT'     => 'I',
            'INT'           => 'I',
            'INTEGER'       => 'I',
            'BIGINT'        => 'I',
            'FLOAT'         => 'N',
            'DOUBLE'        => 'N',
            'DOUBLEPRECISION' => 'N',
            'FLOAT'         => 'N',
            'DECIMAL'       => 'N',
            'DEC'           => 'N',

            'DATE'          => 'D',
            'DATETIME'      => 'T',
            'TIMESTAMP'     => 'T',
            'TIME'          => 'T',
            'YEAR'          => 'I',

            'CHAR'          => 'C',
            'NCHAR'         => 'C',
            'VARCHAR'       => 'C',
            'NVARCHAR'      => 'C',
            'BINARY'        => 'B',
            'VARBINARY'     => 'B',
            'TINYBLOB'      => 'X',
            'TINYTEXT'      => 'X',
            'BLOB'          => 'X',
            'TEXT'          => 'X',
            'MEDIUMBLOB'    => 'X',
            'MEDIUMTEXT'    => 'X',
            'LONGBLOB'      => 'X',
            'LONGTEXT'      => 'X',
            'ENUM'          => 'C',
            'SET'           => 'C',
        );

        $rs = $this->_query(sprintf($this->META_COLUMNS_SQL, $table));
        $retarr = array();
		while (($row = mysql_fetch_row($rs))) {
		    $field = array();
		    $field['name'] = $row[0];
			$type = $row[1];

			$field['scale'] = null;
			$queryArray = false;
			if (preg_match("/^(.+)\((\d+),(\d+)/", $type, $queryArray)) {
				$field['type'] = $queryArray[1];
				$field['maxLength'] = is_numeric($queryArray[2]) ? $queryArray[2] : -1;
				$field['scale'] = is_numeric($queryArray[3]) ? $queryArray[3] : -1;
			} elseif (preg_match("/^(.+)\((\d+)/", $type, $queryArray)) {
				$field['type'] = $queryArray[1];
				$field['maxLength'] = is_numeric($queryArray[2]) ? $queryArray[2] : -1;
			} elseif (preg_match("/^(enum)\((.*)\)$/i", $type, $queryArray)) {
				$field['type'] = $queryArray[1];
				$arr = explode(",",$queryArray[2]);
				$field['enums'] = $arr;
				$zlen = max(array_map("strlen",$arr)) - 2; // PHP >= 4.0.6
				$field['maxLength'] = ($zlen > 0) ? $zlen : 1;
			} else {
				$field['type'] = $type;
				$field['maxLength'] = -1;
			}
			$field['simpleType'] = $typeMap[strtoupper($field['type'])];
			if ($field['simpleType'] == 'C' && $field['maxLength'] > 250) {
			    $field['simpleType'] = 'X';
			}
			$field['notNull'] = ($row[2] != 'YES');
			$field['primaryKey'] = ($row[3] == 'PRI');
			$field['autoIncrement'] = (strpos($row[5], 'auto_increment') !== false);
			if ($field['autoIncrement']) { $field['simpleType'] = 'R'; }
			$field['binary'] = (strpos($type,'blob') !== false);
			$field['unsigned'] = (strpos($type,'unsigned') !== false);

			if (!$field['binary']) {
				$d = $row[4];
				if ($d != '' && $d != 'NULL') {
					$field['hasDefault'] = true;
					$field['defaultValue'] = $d;
				} else {
					$field['hasDefault'] = false;
				}
			}
			$retarr[strtoupper($field['name'])] = $field;
		}
		return $retarr;
    }

    /**
     * 返回数据库可以接受的日期格式
     *
     * @param int $timestamp
     */
    function dbTimeStamp($timestamp) {
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * 查询方法，根据查询结果决定是否显示错误信息
     *
     * @param string $sql
     * @param boolean $throw
     *
     * @return mixed
     */
    function _query($sql, $throw = true) {
        $this->log[] = $sql;
        log_message('sql: ' . $sql, 'debug');
        $result = mysql_query($sql, $this->conn);
        if ($result !== FALSE) {
            return $result;
        }
        if (!$throw) { return $result; }
        load_class('FLEA_Db_Exception_SqlQuery');
        __THROW(new FLEA_Db_Exception_SqlQuery($sql, mysql_error($this->conn), mysql_errno($this->conn)));
        return false;
    }

    /**
     * 根据 SQL 语句和提供的参数数组，生成最终的 SQL 语句
     *
     * @param string $sql
     * @param array $inputarr
     *
     * @return string
     */
    function _prepareSql($sql, & $inputarr) {
        $sqlarr = explode('?', $sql);
        $sql = '';
        $ix = 0;
        foreach ($inputarr as $v) {
            $sql .= $sqlarr[$ix];
			$typ = gettype($v);
			if ($typ == 'string') {
				$sql .= $this->qstr($v);
			} else if ($typ == 'double') {
				$sql .= str_replace(',', '.', $v);
			} else if ($typ == 'boolean') {
				$sql .= $v ? $this->TRUE_VALUE : $this->FALSE_VALUE;
			} else if ($v === null) {
				$sql .= 'NULL';
			} else {
				$sql .= $v;
			}
			$ix += 1;
        }
		if (isset($sqlarr[$ix])) {
			$sql .= $sqlarr[$ix];
			if ($ix + 1 != count($sqlarr)) {
			    user_error("Input array does not match '?' : " .
                    htmlspecialchars($sql), 0);
                return false;
			}
		} else if ($ix != count($sqlarr)) {
		    user_error("Input array does not match '?' : " .
                htmlspecialchars($sql), 0);
            return false;
		}
		return $sql;
    }
}
