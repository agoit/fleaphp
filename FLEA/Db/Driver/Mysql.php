<?php
/////////////////////////////////////////////////////////////////////////////
// ����ļ��� FleaPHP ��Ŀ��һ����
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// Ҫ�鿴�����İ�Ȩ��Ϣ�������Ϣ����鿴Դ�����и����� COPYRIGHT �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * ���� FLEA_Db_Driver_Mysql ����
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package DB
 * @version $Id: Mysql.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * ���� mysql ��չ�����ݿ���������
 *
 * @package DB
 */
class FLEA_Db_Driver_Mysql
{
    /**
     * ���� genSeq()��dropSeq() �� nextId() �� SQL ��ѯ���
     */
    var $NEXT_ID_SQL    = "UPDATE %s SET ID = LAST_INSERT_ID(ID + 1)";
    var $CREATE_SEQ_SQL = "CREATE TABLE %s (id INT NOT NULL)";
    var $INIT_SEQ_SQL   = "INSERT INTO %s VALUES (%s)";
    var $DROP_SEQ_SQL   = "DROP TABLE %s";
    var $GET_ID_SQL     = "SELECT LAST_INSERT_ID()";

    /**
     * ������� true��false �� null �����ݿ�ֵ
     */
    var $TRUE_VALUE  = 1;
    var $FALSE_VALUE = 0;
    var $NULL_VALUE = 'NULL';

    /**
     * ���ڻ�ȡԪ���ݵ� SQL ��ѯ���
     */
    var $META_COLUMNS_SQL = "SHOW COLUMNS FROM %s";

    /**
	 * ���ݿ�������Ϣ
	 *
	 * @var array
	 */
	var $dsn = null;

	/**
	 * ���ݿ����Ӿ��
	 *
	 * @var resource
	 */
	var $conn = null;

	/**
	 * ���� SQL ��ѯ����־
	 *
	 * @var array
	 */
	var $log = array();

	/**
	 * ���һ�β���������� nextId() �������صĲ��� ID
	 *
	 * @var mixed
	 */
	var $_insertId = null;

	/**
	 * ���캯��
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
     * �������ݿ�
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
     * �ر����ݿ�����
     */
    function close() {
        if (!$this->conn) {
            mysql_close($this->conn);
        }
        $this->_insertId = null;
        $this->conn = null;
    }

    /**
     * ִ��һ����ѯ������һ�� resource ���� boolean ֵ
     *
     * @param string $sql
     * @param array $inputarr
     * @param boolean $throw ָʾ��ѯ����ʱ�Ƿ��׳��쳣
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
     * ת���ַ���
     *
     * @param string $value
     *
     * @return mixed
     */
    function qstr($value) {
        return "'" . mysql_real_escape_string($value, $this->conn) . "'";
    }

    /**
     * �����ݱ�����ת��Ϊ��ȫ�޶���
     *
     * @param string $tableName
     *
     * @return string
     */
    function qtable($tableName) {
        return '`' . $tableName . '`';
    }

    /**
     * ���ֶ���ת��Ϊ��ʶ����������Ϊ�ֶ��������ݿ�ؼ�����ͬ���µĴ���
     *
     * @param string $fieldName
     *
     * @return string
     */
    function qfield($fieldName) {
        return '`' . $fieldName . '`';
    }

    /**
     * Ϊ���ݱ������һ������ֵ
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
     * ����һ���µ����У������ص�һ��ֵ
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
     * ɾ��һ������
     *
     * �����ʵ�������ݿ�ϵͳ�йء�
     *
     * @param string $seqName
     */
    function dropSeq($seqName = 'sdboseq') {
        return $this->_query(sprintf($this->DROP_SEQ_SQL, $seqName));
    }

    /**
     * ��ȡ�����ֶε����һ��ֵ
     *
     * @return mixed
     */
    function insertId() {
        $this->_insertId = $this->getOne($this->GET_ID_SQL);
        return $this->_insertId;
    }

    /**
     * �������һ�����ݿ�����ܵ�Ӱ��ļ�¼��
     *
     * @return int
     */
    function affectedRows() {
        return mysql_affected_rows($this->conn);
    }

    /**
     * �Ӽ�¼���з���һ������
     *
     * @param resouce $res
     *
     * @return array
     */
    function fetchRow($res) {
        return mysql_fetch_row($res);
    }

    /**
     * �Ӽ�¼���з���һ�����ݣ��ֶ�����Ϊ����
     *
     * @param resouce $res
     *
     * @return array
     */
    function fetchAssoc($res) {
        return mysql_fetch_assoc($res);
    }

    /**
     * �ͷŲ�ѯ���
     *
     * @param resource $res
     *
     * @return boolean
     */
    function freeRes($res) {
        return mysql_free_result($res);
    }

    /**
     * �����޶���¼���Ĳ�ѯ
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
     * ִ��һ����ѯ�����ز�ѯ�����¼��
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
     * ִ��һ����ѯ�����ز�ѯ�����¼����������ָ���ֶη���
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
     * ִ�в�ѯ�����ص�һ����¼�ĵ�һ���ֶ�
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
     * ִ�в�ѯ�����ص�һ����¼
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
     * ִ�в�ѯ�����ؽ�����ĵ�һ��
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
     * ����ָ����������ͼ����Ԫ����
     *
     * ���ִ���ο� ADOdb ʵ�֡�
     *
     * ÿ���ֶΰ����������ԣ�
     *
     * name:            �ֶ���
     * scale:           С��λ��
     * type:            �ֶ�����
     * simpleType:      ���ֶ����ͣ������ݿ��޹أ�
     * maxLength:       ��󳤶�
     * notNull:         �Ƿ������� NULL ֵ
     * primaryKey:      �Ƿ�������
     * autoIncrement:   �Ƿ����Զ������ֶ�
     * binary:          �Ƿ��Ƕ���������
     * unsigned:        �Ƿ����޷�����ֵ
     * hasDefault:      �Ƿ���Ĭ��ֵ
     * defaultValue:    Ĭ��ֵ
     *
     * @param string $table
     *
     * @return array
     */
    function metaColumns($table) {
        /**
         *	C ����С�ڵ��� 250 ���ַ���
         *	X ���ȴ��� 250 ���ַ���
         *	B ����������
         * 	N ��ֵ���߸�����
         *	D ����
         *	T TimeStamp
         * 	L �߼�����ֵ
         *	I ����
         *  R �Զ������������
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
     * �������ݿ���Խ��ܵ����ڸ�ʽ
     *
     * @param int $timestamp
     */
    function dbTimeStamp($timestamp) {
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * ��ѯ���������ݲ�ѯ��������Ƿ���ʾ������Ϣ
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
     * ���� SQL �����ṩ�Ĳ������飬�������յ� SQL ���
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
