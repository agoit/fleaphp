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
 * ���� FLEA_Db_TableDataGateway ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package DB
 * @version $Id: TableDataGateway.php 683 2007-01-05 16:27:22Z dualface $
 */

// {{{ constants
/**
 * ��������ֶ���
 */
if (!defined('LINK_KEY')) {
    define('LINK_KEY', 'ref__row__id');
}

/**
 * ���ֹ���
 */
define('HAS_ONE',       1);
define('BELONGS_TO',    2);
define('HAS_MANY',      3);
define('MANY_TO_MANY',  4);
// }}}

/**
 * FLEA_Db_TableDataGateway ���װ�����ݱ�� CRUD ����
 *
 * ���ÿ�����ݱ�������Ӧ�ô� FLEA_Db_TableDataGateway �����Լ����ࡣ
 * ��ͨ����ӷ�������װ��Ը����ݱ�ĸ����ӵ����ݿ������
 *
 * @package DB
 * @author ������ dualface@gmail.com
 * @version 1.1
 */
class FLEA_Db_TableDataGateway
{
    /**
     * ������ǰ׺�����ݱ���
     *
     * �������������û�и��Ǵ˱����������������������Ϊ���ݱ�����
     *
     * @var string
     */
    var $tableName = null;

    /**
     * ���й���׼���Ժ�����ݱ����ƣ�����ǰ׺
     *
     * @var string
     */
    var $fullTableName = null;

    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey = null;

    /**
     * ָʾ�ڱ������ݵ����ݿ⣨������¼�Լ����¼�¼��ʱ�Ƿ��Զ���֤����
     *
     * @var boolean
     */
    var $autoValidation = true;

    /**
     * ����һ��һ����
     *
     * 1����������ڹ������У�
     * 2������ʱ����й����������Զ���������¹�����ļ�¼��
     * 3��ɾ�������¼ʱ�Զ�ɾ��������¼��
     *
     * ʾ����
     * ��ǰ��Ϊ users�����ڴ洢�û��˻�����ÿ���û��˻�����ֻ��һ����Ӧ�ĸ�����Ϣ��profile����¼��
     *
     * ��ʽһ��
     * <code>
     * class Users
     * {
     *     var $hasOne = array(
     *         array(
     *             'tableClass'  => 'Profiles',
     *             'foreignKey'  => 'profile_id',
     *             'mappingName' => 'profile',
     *         ),
     *     );
     * }
     * </code>
     *
     * ������ĸ�ʽ�У�foreignKey ��ʾ�ڹ���������ʲô�ֶδ洢��������������á�
     * mappingName ��ʾ������ķ��ؽ���У���ʲô���ֱ������������ݡ�
     * ������ṩ mappingName ��������ٶ�ʹ�� tableClass��
     *
     * ��ʽ����
     * <code>
     * class Users
     * {
     *     var $hasOne = 'Profiles';
     * }
     * </code>
     *
     * ��ʽ����һ�ּ�д����foreignKey �ֶ�����������������ֶ�������ͬ��
     *
     * @var array
     */
    var $hasOne = null;

    /**
     * �����������
     *
     * 1����������������У�
     * 2������ʱ�����Զ����¹�����ļ�¼��
     * 3��ɾ��ʱҲ������¹�����ļ�¼��
     *
     * ʾ����
     * ������¶�����ĳһ����Ŀ��
     *
     * ��ʽһ��
     * <code>
     * class Articles
     * {
     *     var $belongsTo = array(
     *         array(
     *             'tableClass'  => 'Columns',
     *             'foreignKey'  => 'column_id',
     *             'mappingName' => 'column'
     *         ),
     *     );
     * }
     * </code>
     *
     * ������ĸ�ʽ�У�foreignKey ��ʾ�ڵ�ǰ������ʲô�ֶδ洢�Թ�������������á�
     * mappingName ��ʾ������ķ��ؽ���У���ʲô���ֱ������������ݡ�
     * ������ṩ mappingName ��������ٶ�ʹ�� tableClass��
     *
     * ��ʽ����
     * <code>
     * class Articles
     * {
     *     var $belongsTo = 'Columns';
     * }
     * </code>
     *
     * ��ʽ����һ�ּ�д����foreignKey �ֶ������͹�����������ֶ�����ͬ��
     *
     * @var array
     */
    var $belongsTo = null;

    /**
     * ����һ�Զ����
     *
     * 1����������ڹ������У�
     * 2������ʱ�Զ����¹�����ļ�¼��
     * 3��ɾ�������¼ʱ�Զ�ɾ��������¼��
     *
     * ʾ����
     * ÿ���û���user���ж��Ŷ��� order��
     *
     * ��ʽһ��
     * <code>
     * class Users
     * {
     *     var $hasMany = array(
     *         array(
     *             'tableClass'  => 'Orders',
     *             'foreignKey'  => 'user_id',
     *             'mappingName' => 'orders',
     *         ),
     *     );
     * }
     * </code>
     *
     * ��һ�Զ��ϵ�У���ǰ���������Թ�������������á�
     * �����ڹ������б���Ե�ǰ����������á�
     *
     * ������ĸ�ʽ�У�foreignKey ָʾ�ڹ���������ʲô�ֶδ洢�Ե�ǰ����������á�
     * mappingName ��ʾ������ķ��ؽ���У���ʲô���ֱ������������ݡ�
     * ������ṩ mappingName ��������ٶ�ʹ�� tableClass��
     *
     * ��ʽ����
     * <code>
     * class Users
     * {
     *     var $hasMany = 'Orders';
     * }
     * </code>
     *
     * ��д���У�foreignKey �ֶ������͵�ǰ��������ֶ�����ͬ��
     *
     * @var array
     */
    var $hasMany = null;

    /**
     * �����Զ����
     *
     * 1������������м�����棻
     * 2������ʱ�Զ������м��
     * 3��ɾ�������¼ʱ�Զ�ɾ���м�����ؼ�¼��
     *
     * ʾ����
     * ÿ����Ա��member������ӵ�ж����ɫ��role������ÿ����ɫҲ����ָ���������Ա��
     *
     * ��ʽһ��
     * <code>
     * class Members
     * {
     *     var $manyToMany = array(
     *         array(
     *             'tableClass'      => 'Roles',
     *             'joinTable'       => 'member_roles',
     *             'foreignKey'      => 'member_id',
     *             'assocforeignKey' => 'role_id',
     *             'mappingName'     => 'roles',
     *         ),
     *     );
     * }
     * </code>
     *
     * �ڶ�Զ��ϵ�У���ǰ���������Թ�������������á�
     * ������һ���м�����汣��Ե�ǰ��͹�������������á�
     *
     * ������ĸ�ʽ�У�joinTable ��ʾ�м������֡�foreignKey ��
     * assocforeignKey �ֱ��ʾ���м��������ʲô�ֶδ洢�������
     * �����������ֶε����á�
     *
     * mappingName ��ʾ������ķ��ؽ���У���ʲô���ֱ������������ݡ�
     * ������ṩ mappingName ��������ٶ�ʹ�� tableClass��
     *
     * ��ʽ����
     * <code>
     * class Members
     * {
     *     var $manyToMany = 'Roles';
     * }
     * </code>
     *
     * ��д���У�foreignKey �ֶ������͵�ǰ��������ֶ�����ͬ��
     * assocforeignKey �ֶ�������͹������ݱ�������ֶ�����ͬ��
     * ���м�����ƽ��� FLEA_Db_TableDataGateway::getMidtableName() �������㡣
     *
     * @var array
     */
    var $manyToMany = null;

    /**
     * ָʾ�Ƿ��Զ����������������ڲ�ѯ����ʱ��ȡ�����������
     *
     * @var boolean
     */
    var $autoLink = true;

    /**
     * ���ݿ���ʶ���
     *
     * @var FLEA_Db_SDBO
     */
    var $dbo = null;

    /**
     * ��ǰ���ݱ��Ԫ����
     *
     * @var array
     */
    var $meta = null;

    /**
     * �洢������Ϣ
     *
     * $this->links ��һ�����飬�����б��� TableLink ����
     *
     * @var array
     */
    var $links = array();

    /**
     * ����������֤�� Validation ����
     *
     * @var FLEA_Helper_Validation
     */
    var $validation = null;

    /**
     * ������¼ʱ��Ҫ�Զ����뵱ǰ timestamp ���ֶ�
     *
     * @var array
     */
    var $createdTimeFields = array('CREATED', 'CREATED_ON', 'CREATED_AT');

    /**
     * ���¼�¼ʱ��Ҫ�Զ����뵱ǰ timestamp ���ֶ�
     *
     * @var array
     */
    var $updatedTimeFields = array('UPDATED', 'UPDATED_ON', 'UPDATED_AT');

    /**
     * ��������ʱ���������е����ݱ�����ģʽ
     *
     * @var string
     */
    var $sequenceNamePattern = 'seq_%s';

    /**
     * ���һ�ζ����ݽ�����֤�Ľ��
     *
     * @var mixed
     */
    var $_lastValidation = null;

    /**
     * ���� FLEA_Db_TableDataGateway ʵ��
     *
     * @param string $tableName
     * @param boolean $skipLink
     * @param boolean $noAutoInit
     *
     * @return FLEA_Db_TableDataGateway
     */
    function FLEA_Db_TableDataGateway($tableName = null, $skipLink = null, $noAutoInit = false) {
        log_message('Construction FLEA_Db_TableDataGateway(' . get_class($this) . ')', 'debug');
        if ($tableName) { $this->tableName = $tableName; }
        $this->fullTableName = get_app_inf('dbTablePrefix') . $this->tableName;

        // ��ʼ����֤�������
        if ($this->autoValidation && $noAutoInit !== true) {
            $this->validation =& get_singleton(get_app_inf('dbValidationProvider'));
        }

        // ��ʼ��
        if ($skipLink) {
            $this->autoLink = false;
        }

        if ($noAutoInit == false && get_app_inf('dbTDGAutoInit')) {
            $dbo =& get_dbo(get_app_inf('dbDSN'));
            $this->setSDBO($dbo, $skipLink);
            if ($this->autoLink) {
                $this->relink();
            }
        }
    }

    /**
     * ���� FLEA_Db_SDBO
     *
     * @param FLEA_Db_SDBO $dbo
     */
    function setSDBO(& $dbo) {
        // ���ӵ����ݿ�
        $this->dbo =& $dbo;
        if (!$this->dbo->conn) {
            $this->dbo->connect();
        }
        // ��׼�����ݱ�����
        $this->fullTableName = $this->dbo->qtable($this->fullTableName);
        // ȡ�����ݱ��Ԫ����
        $this->meta = $this->dbo->metaColumns($this->fullTableName);
        // �����Ҫ���²������ֶ���
        if (is_null($this->primaryKey)) {
            foreach ($this->meta as $meta) {
                if ($meta['primaryKey']) {
                    $this->primaryKey = $meta['name'];
                    break;
                }
            }
            if (is_null($this->primaryKey)) {
                load_class('FLEA_Db_Exception_MissingPrimaryKey');
                __THROW(new FLEA_Db_Exception_MissingPrimaryKey(
                    'Table ' . $this->fullTableName . '.PRIMARY_KEY'));
                return false;
            }
        }

        return true;
    }

    /**
     * �����鷽ʽ���ط��������ĵ�һ����¼�����й��������ݣ���ѯû�н������ false
     *
     * �÷���
     * <code>
     *   $order = $ordersTable->find($conditions);
     * </code>
     *
     * $conditions �������÷��ܶ࣬�б����£�
     * <code>
     *   // ��������Ϊ����ֵ���в�ѯ
     *   $conditions = 23;
     *
     *   // �ַ�������Ϊ�Զ����������в�ѯ
     *   $conditions = "name = 'dualface'";
     *
     *   // ���齫����ÿ��Ԫ�ص�������д���
     *   // ���Ԫ�ؽ��� AND ������������ӡ�
     *   // �����������ͬ�� name <> 'dualface' AND sex = 'male'
     *   $conditions = array("name <> 'dualface'", "sex = 'male'");
     *   // Ԫ��Ҳ��������������ַ���
     *   $conditions = array(
     *       "born = '1977/10/24'",
     *       array('sex' => 'sex'),
     *   );
     * </code>
     *
     * ��ʹ�ù��ڸ��ӵĲ�ѯ���鲢����һ�������⡣
     * �ڿ��ܵ�����£�Ӧ�þ�����ʹ���ַ�����Ϊ��ѯ������
     * ��Ϊ�����ַ��������������κζ��⴦�����Ի����ߵĴ����ٶȡ�
     *
     * ��Ȼ��ʹ����������ѯ���������Ա��ڶ��������ϣ�
     * ������ TableDataGateway �Զ������ַ���ת������⡣
     *
     * @param mixed $conditions ��ѯ����
     * @param string $sort ����
     * @param string $fields
     *
     * @return array
     */
    function find($conditions, $sort = null, $fields = '*') {
        $rowset = $this->findAll($conditions, $sort, 1, $fields);
        if ($rowset) {
            return $rowset[key($rowset)];
        } else {
            return false;
        }
    }

    /**
     * ��ѯ���з��������ļ�¼��������ݣ�����һ�� FLEA_Db_RowSet ����
     *
     * �����������������ܴ���ô������ʹ�� findAll() ��ѯ֮ǰ������
     * ��������ڶ���� $autoLink ��Ա����Ϊ false ����ֹ�Թ�����Ĳ�ѯ��
     *
     * @param mixed $conditions ��ѯ����
     * @param string $sort
     * @param mixed $limit
     * @param string $fields
     *
     * @return array
     */
    function findAll($conditions = null, $sort = null, $limit = null, $fields = '*') {
        // �����ѯ����
        $where = $this->_prepareConditions($conditions);
        if ($where) {
            $whereby = ' WHERE ' . $where;
        } else {
            $whereby = '';
        }
        // ��������
        if ($sort != '') {
            $orderby = ' ORDER BY ' . $sort;
        } else {
            $orderby = '';
        }
        // ���� $limit
        if (is_array($limit)) {
            list($length, $offset) = $limit;
        } else {
            $length = $limit;
            $offset = null;
        }

        // ��ѯ��ǰ��
        $sql = 'SELECT ' . $fields . ', ' . $this->fullTableName . '.' . $this->primaryKey .
            ' AS ' . LINK_KEY . ' FROM ' . $this->fullTableName;
    	$fullSql = $sql . $whereby . $orderby;
    	$fullSql = str_replace('%MT%', $this->fullTableName, $fullSql);
        if ($length !== null || $offset !== null) {
            $res = $this->dbo->selectLimit($fullSql, $length, $offset);
        } else {
            $res = $fullSql;
        }
        $rowset = $this->dbo->getAll($res);
        if (count($this->links) == 0 || !$this->autoLink) {
            return $rowset;
        }

        /**
         * Ϊ���й������ݱ�����ѯ׼��
         *
         * $this->_getJoinsSql() ����һ����ά���顣ÿ���а�������Ԫ�أ�
         *   $join[0] ��ѯ��䣻
         *   $join[1] TableLink ����ʵ����
         */
        $joins =& $this->_getJoinsSql($where);
        foreach ($joins as $join) {
            list($joinSql, $link, $mainTableAlias, $assocTableAlias) = $join;
            /* @var $link FLEA_Db_TableLink */
            $joinSql = str_replace('%MT%', $mainTableAlias, $joinSql);
            $data = $this->dbo->getAllGroupBy($joinSql, LINK_KEY, $link->oneToOne);
            $linkName = $link->mappingName;
            if ($link->oneToOne) {
                foreach ($rowset as $offset => $row) {
                    $ref = $row[LINK_KEY];
                    if (isset($data[$ref])) {
                        $rowset[$offset][$linkName] = $data[$ref];
                    } else {
                        $rowset[$offset][$linkName] = null;
                    }
                }
            } else {
                foreach ($rowset as $offset => $row) {
                    $ref = $row[LINK_KEY];
                    if (isset($data[$ref])) {
                        $rowset[$offset][$linkName] = $data[$ref];
                    } else {
                        $rowset[$offset][$linkName] = array();
                    }
                }
            }
        }
        return $rowset;
    }

    /**
     * ���ؾ���ָ���ֶ�ֵ�ĵ�һ����¼
     *
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    function findByField($field, $value, $sort = null, $fields = '*') {
        $row = $this->find($field . ' = ' . $this->dbo->qstr($value), $sort, $fields);
        return $row;
    }

    /**
     * ���ؾ���ָ���ֶ�ֵ�����м�¼
     *
     * @param string $field
     * @param mixed $value
     * @param string $sort
     * @param array $limit
     * @param string $fields
     *
     * @return array
     */
    function findAllByField($field, $value, $sort = null, $limit = null, $fields = '*') {
        $rowset = $this->findAll($field . ' = ' . $this->dbo->qstr($value), $sort, $limit, $fields);
        return $rowset;
    }

    /**
     * ֱ��ʹ�� sql ����ȡ��¼
     *
     * �÷������ᴦ��������ݱ�
     *
     * @param string $sql
     *
     * @return array
     */
    function findBySql($sql) {
        $rowset = $this->dbo->getAll($sql);
        return $rowset;
    }

    /**
     * ���ط��������ļ�¼����
     *
     * @param mixed $conditions
     * @param string $fields ͳ�Ƽ�¼ʱ�漰���ֶ�
     *
     * @return int
     */
    function findCount($conditions = null, $fields = '*') {
        $sql = 'SELECT COUNT(' . $fields . ') FROM ' . $this->fullTableName;
        $where = $this->_prepareConditions($conditions);
        if ($where) {
            $whereby = ' WHERE ' .  $where;
        } else {
            $whereby = '';
        }
        $sql .= $whereby;
        $sql = str_replace('%MT%', $this->fullTableName, $sql);
        return (int)$this->dbo->getOne($sql);
    }

    /**
     * �������ݵ����ݿ�
     *
     * Ϊ��������ܣ�Ӧ����ȷ���� create() �����������¼�¼��
     * ���� update() �������������м�¼��
     *
     * @param array $row
     *
     * @return boolean
     */
    function save($row) {
        if (!isset($row[$this->primaryKey])) {
            return $this->create($row);
        }
        return $this->update($row);
    }

    /**
     * �滻һ�����м�¼������¼�¼�����ؼ�¼������ֵ
     *
     * @param array $row
     *
     * @return mixed
     */
    function replace($row) {
        $row = (array)$row;
        $this->_setCreatedTimeFields($row);
        $fields = '';
        $values = '';
        foreach ($row as $field => $value) {
            $fields .= $this->dbo->qfield($field) . ', ';
            $values .= $this->dbo->qstr($value) . ', ';
        }
        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);
        $sql = "REPLACE INTO {$this->fullTableName} ({$fields}) VALUES ({$values})";
        if (!$this->dbo->execute($sql)) { return null; }

        if (isset($row[$this->primaryKey]) && !empty($row[$this->primaryKey])) {
            return $row[$this->primaryKey];
        }

        return $this->dbo->insertId();
    }

    /**
     * ����һ�����еļ�¼
     *
     * @param array $row
     *
     * @return mixed
     */
    function update($row) {
    	// �¼� callback
        if (method_exists($this, '_beforeUpdate')) {
            if (!$this->_beforeUpdate($row)) {
                return false;
            }
        }

        // ��������
        if (!isset($row[$this->primaryKey])) {
            load_class('FLEA_Db_Exception_MissingPrimaryKey');
            __THROW(new FLEA_Db_Exception_MissingPrimaryKey($this->primaryKey));
            return false;
        }

        // �Զ����� updatedTimeFields �ֶ�
        $this->_setUpdatedTimeFields($row);;

        // �Զ���֤����
        if ($this->autoValidation) {
            $result = $this->checkRowData($row, true);
            if (!empty($result)) {
                load_class('FLEA_Exception_ValidationFailed');
                __THROW(new FLEA_Exception_ValidationFailed($result, $row));
                return false;
            }
        }

		// �¼� callback
        if (method_exists($this, '_beforeUpdateDb')) {
            if (!$this->_beforeUpdateDb($row)) {
                return false;
            }
        }

        // ���� SQL ���
        $sql = 'UPDATE ' . $this->fullTableName . ' SET ';
        $pk = $row[$this->primaryKey];
        unset($row[$this->primaryKey]);
        $fc = 0;
        foreach ($row as $key => $value) {
            if (isset($this->meta[strtoupper($key)])) {
                $sql .= $this->dbo->qfield($key) .
                    ' = ' . $this->dbo->qstr($value) . ', ';
                $fc++;
            }
        }
        $row[$this->primaryKey] = $pk;
        $qpk = $this->dbo->qstr($pk);
        if ($fc > 0) {
            $sql = substr($sql, 0, -2);
            $sql .= ' WHERE ' . $this->primaryKey . ' = ' . $qpk;
            $sql = str_replace('%MT%', $this->fullTableName, $sql);
            if ($this->dbo->execute($sql) == false) { return false; }
        }

        if ($this->autoLink) {
            // ����������ݱ�
            foreach ($this->links as $link) {
                /* @var $link FLEA_Db_TableLink */
                if (!$link->enabled || !isset($row[$link->mappingName])
                        || !is_array($row[$link->mappingName])) { continue; }
                $assoc = $row[$link->mappingName];
                switch ($link->type) {
                case MANY_TO_MANY:
                    /**
                     * ���ڶ�Զ�������Զ������м����ݱ�
                     *
                     * �ڸ��¶�Զ����ʱ��Ҫ���ύ�ļ�¼���ݰ����м�����Ϣ��
                     * ���磺
                     *     users �����û���Ϣ��roles �����ɫ��Ϣ
                     *     ��ô roles_users �м����Ǳ���������Ĺ�����Ϣ��
                     *
                     * �ڸ��¶�Զ����ʱ����¼��Ӧ�ð���һ���ض����ֶΣ��ֶ���
                     * Ϊ�ù����� mappingName ������
                     *
                     * �ֶ�������һ��һά���飬����ÿһ����Ŀ���ǹ����������ֵ��
                     */
                    /* @var $link FLEA_Db_ManyToManyLink */
                    $sql = 'SELECT ' . $link->assocForeignKey .
                           ' FROM ' . $link->joinTable . ' WHERE ' .
                           $link->foreignKey . ' = ' . $qpk;
                    // ����ȡ�����еĹ�����Ϣ��Ȼ��ȷ��Ҫɾ���Ĺ�����Ϣ��Ҫ��ӵĹ�����Ϣ
                    $existsAssoc = $this->dbo->getCol($sql);
                    $insertAssoc = array_diff($assoc, $existsAssoc);
                    $removeAssoc = array_diff($existsAssoc, $assoc);
                    $sql = 'INSERT INTO ' . $link->joinTable .
                           ' (' . $link->foreignKey . ', ' .
                           $link->assocForeignKey . ')' .
                           ' VALUES (' . $qpk . ', %s)';
                    foreach ($insertAssoc as $assocId) {
                        $this->dbo->execute(sprintf($sql, $this->dbo->qstr($assocId)));
                    }

                    $sql = 'DELETE FROM ' . $link->joinTable .
                           ' WHERE ' . $link->foreignKey . ' = ' . $qpk .
                           ' AND ' . $link->assocForeignKey . ' = %s';
                    foreach ($removeAssoc as $assocId) {
                        $this->dbo->execute(sprintf($sql, $this->dbo->qstr($assocId)));
                    }
                    break;
                case HAS_ONE:
                    /**
                     * ���� HAS_ONE ���������¼�¼ʱ�Զ����¹�����¼������
                     */
                    if (!empty($assoc) && $link->linkUpdate) {
                        $assoc[$link->foreignKey] = $pk;
                        $assocTDG =& get_singleton($link->tableClass);
                        /* @var $assocTDG FLEA_Db_TableDataGateway */
                        if (!$assocTDG->save($assoc)) { return false; }
                    }
                    break;
                case HAS_MANY:
                    /**
                     * ���� HAS_MANY ���������¼�¼ʱ�Զ����¹�����¼������
                     */
                    if (!empty($assoc) && $link->linkUpdate) {
                        $test = reset($assoc);
                        if (!is_array($test)) {
                            $assoc = array($assoc);
                        }
                        $assocTDG =& get_singleton($link->tableClass);
                        /* @var $assocTDG FLEA_Db_TableDataGateway */
                        foreach ($assoc as $arow) {
                            $arow[$link->foreignKey] = $pk;
                            if (!$assocTDG->save($arow)) { return false; }
                        }
                    }
                    break;
                }
            }
        }

		// �¼� callback
        if (method_exists($this, '_afterUpdateDb')) {
        	$this->_afterUpdateDb($row);
        }

        return true;
    }

    /**
     * ���·��������ļ�¼�����ظ��µļ�¼����
     *
     * @param mixed $conditions
     * @param array $row
     * @param boolean $checkCommend
     *
     * @return int
     */
    function updateByConditions($conditions, $row, $checkCommend = false) {
        $where = $this->_prepareConditions($conditions);
        $sql = "UPDATE {$this->fullTableName} SET ";
        $this->_setUpdatedTimeFields($row);

        foreach ($row as $field => $value) {
            if (is_int($field) && $checkCommend) {
                $sql .= $value;
            } else {
                $sql .= $field . ' = ' . $this->dbo->qstr($value);
            }
            $sql .= ', ';
        }
        $sql = substr($sql, 0, -2);
        if ($where != '') {
            $sql .= " WHERE {$where}";
        }

        $sql = str_replace('%MT%', $this->fullTableName, $sql);
        $this->dbo->execute($sql);
        return $this->dbo->affectedRows() > 0;
    }

    /**
     * ���¼�¼��ָ���ֶΣ����ظ��µļ�¼����
     *
     * @param mixed $conditions
     * @param string $field
     * @param mixed $value
     *
     * @return int
     */
    function updateField($conditions, $field, $value) {
        $row = array($field => $value);
        return $this->updateByConditions($conditions, $row);
    }

    /**
     * ����ָ���ֶεļ���ֵ�����ظ��µļ�¼����
     *
     * @param mixed $conditions
     * @param string $field
     * @param int $incr
     *
     * @return mixed
     */
    function incrField($conditions, $field, $incr = 1) {
        $row = array("{$field} = {$field} + {$incr}");
        return $this->updateByConditions($conditions, $row, true);
    }

    /**
     * ��Сָ���ֶεļ���ֵ�����ظ��µļ�¼����
     *
     * @param mixed $conditions
     * @param string $field
     * @param int $decr
     *
     * @return mixed
     */
    function decrField($conditions, $field, $decr = 1) {
        $row = array("{$field} = {$field} - {$decr}");
        return $this->updateByConditions($conditions, $row, true);
    }

    /**
     * ����һ���¼�¼�������¼�¼������ֵ
     *
     * @param array $row
     *
     * @return mixed
     */
    function create($row) {
    	// �¼� callback
        if (method_exists($this, '_beforeCreate')) {
            if (!$this->_beforeCreate($row)) {
                return false;
            }
        }

        // �Զ����� createdTimeFields �� updatedTimeFields �ֶ�
        $this->_setCreatedTimeFields($row);

        // ��������
        $pk = strtoupper($this->primaryKey);
        if ($this->meta[$pk]['autoIncrement']) {
            if (isset($row[$this->primaryKey])) {
                if (!empty($row[$this->primaryKey])) {
                    load_class('FLEA_Db_Exception_PrimaryKeyExists');
                    __THROW(new FLEA_Db_Exception_PrimaryKeyExists(
                        $this->primaryKey,
                        $row[$this->primaryKey]));
                    return false;
                } else {
                    unset($row[$this->primaryKey]);
                }
            }
        } else {
            // �����Զ�����һ���µ�����ֵ
            if (!isset($row[$this->primaryKey])) {
                $row[$this->primaryKey] = $this->newInsertId();
            }
        }

        // �Զ���֤����
        if ($this->autoValidation) {
            $result = $this->checkRowData($row);
            if (!empty($result)) {
                load_class('FLEA_Exception_ValidationFailed');
                __THROW(new FLEA_Exception_ValidationFailed($result, $row));
                return false;
            }

            // ���Ĭ��ֵ�ʹ��� NULL
            foreach ($row as $key => $value) {
                if (!empty($value)) { continue; }
                $ukey = strtoupper($key);
                if (!isset($this->meta[$ukey])) { continue; }
                if (isset($this->meta[$ukey]['defaultValue'])) {
                    $row[$key] = $this->meta[$ukey]['defaultValue'];
                } elseif (!$this->meta[$ukey]['notNull']) {
                    unset($row[$key]);
                }
            }
        }

    	// �¼� callback
        if (method_exists($this, '_beforeCreateDb')) {
            if (!$this->_beforeCreateDb($row)) {
                return false;
            }
        }

        // ���� SQL ���
        $sql = 'INSERT INTO ' . $this->fullTableName . ' (';
        $keys = '';
        $values = '';
        $fc = 0;
        foreach ($row as $key => $value) {
            if (isset($this->meta[strtoupper($key)])) {
                $keys .= $this->dbo->qfield($key) . ', ';
                $values .= $this->dbo->qstr($value) . ', ';
                $fc++;
            }
        }
        if ($fc == 0) { return false; }
        $keys = substr($keys, 0, -2);
        $values = substr($values, 0, -2);
        $sql .= $keys . ') VALUES (' . $values . ')';
        $sql = str_replace('%MT%', $this->fullTableName, $sql);
        if ($this->dbo->execute($sql) == false) { return false; }
        $insertId = $this->dbo->insertId();
        if (count($this->links) == 0) { return $insertId; }

        if ($this->autoLink) {
            // ����������ݱ�
            foreach ($this->links as $link) {
                /* @var $link FLEA_Db_TableLink */
                if (!isset($row[$link->mappingName]) ||
                    !is_array($row[$link->mappingName]) ||
                    !$link->linkCreate)
                {
                    continue;
                }
                $assoc = $row[$link->mappingName];

                switch ($link->type) {
                case MANY_TO_MANY:
                    /* @var $link FLEA_Db_ManyToManyLink */
                    $qInsertId = $this->dbo->qstr($insertId);
                    $sql = 'INSERT INTO ' . $link->joinTable .
                           ' (' . $link->foreignKey . ', ' . $link->assocForeignKey . ')' .
                           ' VALUES (' . $qInsertId . ', %s)';
                    foreach ($assoc as $assocId) {
                        $this->dbo->execute(sprintf($sql, $this->dbo->qstr($assocId)));
                    }
                    break;
                case HAS_ONE:
                    $assoc[$link->foreignKey] = $insertId;
                    $assocTDG =& get_singleton($link->tableClass);
                    /* @var $assocTDG FLEA_Db_TableDataGateway */
                    if (!$assocTDG->save($assoc)) { return false; }
                    break;
                case HAS_MANY:
                    $test = reset($assoc);
                    if (!is_array($test)) {
                        $assoc = array($assoc);
                    }
                    $assocTDG =& get_singleton($link->tableClass);
                    /* @var $assocTDG FLEA_Db_TableDataGateway */
                    foreach ($assoc as $arow) {
                        $arow[$link->foreignKey] = $insertId;
                        if (!$assocTDG->save($arow)) { return false; }
                    }
                    break;
                }
            }
        }

    	// �¼� callback
    	if (method_exists($this, '_afterCreate')) {
    		$this->_afterCreate($row, $insertId);
    	}

        return $insertId;
    }

    /**
     * ɾ��ָ�������ü�¼
     *
     * Ϊ����ߴ������ܣ�ɾ����¼ʱ���ᴦ���κι�����
     *
     * @param array $row
     *
     * @return boolean
     */
    function remove($row) {
        if (!is_array($row) || !isset($row[$this->primaryKey])) {
            load_class('FLEA_Db_Exception_MissingPrimaryKey');
            __THROW(new FLEA_Db_Exception_MissingPrimaryKey($this->primaryKey));
            return false;
        }
        return $this->removeByPkv($row[$this->primaryKey]);
    }

    /**
     * ��������ֵɾ����¼
     *
     * @param mixed $id
     *
     * @return boolean
     */
    function removeByPkv($id) {
        if (method_exists($this, '_beforeRemove')) {
            if (!$this->_beforeRemove($id)) {
                return false;
            }
        }

        $id = $this->dbo->qstr($id);
        $sql = "DELETE FROM {$this->fullTableName} WHERE {$this->primaryKey} = {$id}";
        if ($this->dbo->execute($sql) == false) { return false; }
        if (count($this->links) == 0) { return true; }

        if ($this->autoLink) {
            // ����������ݱ�
            foreach ($this->links as $link) {
                /* @var $link FLEA_Db_TableLink */
                switch ($link->type) {
                case MANY_TO_MANY:
                    /* @var $link FLEA_Db_ManyToManyLink */
                    $sql = 'SELECT ' . $link->assocForeignKey .
                           ' FROM ' . $link->joinTable . ' WHERE ' .
                           $link->foreignKey . ' = ' . $id;
                    $existsAssoc = $this->dbo->getCol($sql);
                    $sql = 'DELETE FROM ' . $link->joinTable .
                           ' WHERE ' . $link->foreignKey . ' = ' . $id .
                           ' AND ' . $link->assocForeignKey . ' = %s';
                    foreach ($existsAssoc as $assocId) {
                        $this->dbo->execute(sprintf($sql, $this->dbo->qstr($assocId)));
                    }
                    break;
                case HAS_ONE:
                case HAS_MANY:
                    /**
                     * ���� HAS_ONE �� HAS_MANY ��������Ϊ�����������
                     *
                     * �� $link->linkRemove Ϊ true ʱ��ֱ��ɾ���������еĹ�������
                     * ������¹������ݵ����ֵΪ $link->linkRemoveFillValue
                     */
                    /* @var $link FLEA_Db_HasOneLink */
                    $assocTDG =& get_singleton($link->tableClass);
                    /* @var $assocTDG FLEA_Db_TableDataGateway */
                    if ($link->enabled && $link->linkRemove) {
                        $assocTDG->removeByConditions("{$link->foreignKey} = {$id}");
                    } else {
                        $sql = "UPDATE {$assocTDG->fullTableName} SET {$link->foreignKey} = " .
                            $this->dbo->qstr($link->linkRemoveFillValue) .
                            " WHERE {$link->foreignKey} = {$id}";
                        $this->dbo->execute($sql);
                    }
                    break;
                }
            }
        }

        return true;
    }

    /**
     * ɾ�����������ļ�¼������ɾ���ļ�¼����
     *
     * ɾ����¼ʱ�����Զ����¹������ݱ�
     *
     * @param mixed $conditions
     *
     * @return int
     */
    function removeByConditions($conditions) {
        $where = $this->_prepareConditions($conditions);
        if ($where) {
            $whereby = ' WHERE ' .  $where;
        } else {
            $whereby = '';
        }
        $sql = 'SELECT ' . $this->primaryKey . ' FROM ' . $this->fullTableName;
        $sql .= $whereby;
        $sql = str_replace('%MT%', $this->fullTableName, $sql);
        $idList = $this->dbo->getCol($sql);
        $count = 0;
        foreach ($idList as $id) {
        	$count += ($this->removeByPkv($id) != false);
        }
        return $count;
    }

    /**
     * ɾ�����м�¼
     *
     * @param boolean $skipLink
     *
     * @return int
     */
    function removeAll($skipLink = false) {
        if ($skipLink) {
            $this->dbo->execute('DELETE FROM ' . $this->fullTableName);
            return $this->dbo->affectedRows();
        } else {
            return $this->removeByConditions(null);
        }
    }

    /**
     * ������������ݱ���������
     */
    function clearLink() {
        $this->links = array();
    }

    /**
     * �������������ݱ���ڶ���֮��Ĺ���
     */
    function relink() {
        $this->createLink($this->hasOne,     HAS_ONE);
        $this->createLink($this->belongsTo,  BELONGS_TO);
        $this->createLink($this->hasMany,    HAS_MANY);
        $this->createLink($this->manyToMany, MANY_TO_MANY);
    }

    /**
     * ��ȡָ����������ں����͵Ĺ�������
     *
     * @param string $tableClass
     * @param enum $type
     *
     * @return FLEA_Db_TableLink
     */
    function & getLink($tableClass, $type) {
        foreach ($this->links as $offset => $link) {
            /* @var $link FLEA_Db_TableLink */
            if ($link->tableClass == $tableClass && $link->type == $type) {
                return $this->links[$offset];
            }
        }
        return null;
    }

    /**
     * ��ȡָ�����ֵĹ�������
     *
     * @param string $name
     *
     * @return FLEA_Db_TableLink
     */
    function & getLinkByName($name) {
        foreach ($this->links as $offset => $link) {
            /* @var $link FLEA_Db_TableLink */
            if ($link->name == $name) {
                return $this->links[$offset];
            }
        }
        return null;
    }

    /**
     * ��������
     *
     * @param string|array $relations
     * @param enum $type
     */
    function createLink($relations, $type) {
        load_class('FLEA_Db_TableLink');
        if (!is_array($relations)) {
            $relations = explode(',', $relations);
            foreach ($relations as $relation) {
                $relation = trim($relation);
                if ($relation == '') { continue; }
                $this->links[] =& FLEA_Db_TableLink::createLink(
                    array('tableClass' => $relation), $type);
            }
        } else {
            if (!is_array(reset($relations))) {
                $relations = array($relations);
            }
            foreach ($relations as $relation) {
                $this->links[] =& FLEA_Db_TableLink::createLink($relation, $type);
            }
        }
    }

    /**
     * �����ݽ�����֤
     *
     * ��������Ը��Ǵ˷������Ա���и��ӵ���֤��
     *
     * @param array $row
     * @param boolean $skipEmpty
     *
     * @return array
     */
    function checkRowData($row, $skipEmpty = false) {
        $this->_lastValidation = $this->validation->checkAll($row, $this->meta, $skipEmpty);
        return $this->_lastValidation;
    }

    /**
     * �������һ��������֤�Ľ��
     *
     * @return mixed
     */
    function getLastValidation() {
        return $this->_lastValidation;
    }

    /**
     * ���ص�ǰ���ݱ����һ������ ID
     *
     * @return mixed
     */
    function newInsertId() {
        return $this->dbo->nextId(sprintf($this->sequenceNamePattern, $this->tableName));
    }

    /**
     * ����������ݱ���ڶ�������ϲ�ѯ���
     *
     * ����һ����ά���飺
     *   $join[0] ��ѯ��䣻
     *   $join[1] TableLink ����
     *
     * @param string $where
     *
     * @return array
     */
    function & _getJoinsSql($where) {
        $joins = array();
        $linkKey = LINK_KEY;
        foreach ($this->links as $link) {
            /* @var $link FLEA_Db_TableLink */
            if (!$link->enabled || !$link->linkRead) { continue; }
            $mainTableAlias = $this->fullTableName;
            $assocTableAlias = $link->tableName;
            switch ($link->type) {
            case HAS_ONE:
            case HAS_MANY:
                $sql = "SELECT {$link->fields}, {$mainTableAlias}.{$this->primaryKey} AS {$linkKey}" .
                    " FROM {$link->tableName}" .
                    " LEFT JOIN {$this->fullTableName}" .
                    " ON {$assocTableAlias}.{$link->foreignKey} = {$mainTableAlias}.{$this->primaryKey} ";
                if ($where) {
                	$sql .= ' WHERE ' . $where;
	            	if ($link->conditions) {
	            		$sql .= ' AND ' . $link->conditions;
	            	}
	            } elseif ($link->conditions) {
	            	$sql .= ' WHERE ' . $link->conditions;
	            }
                if ($link->sort) { $sql .= ' ORDER BY ' . $link->sort; }
                break;
            case BELONGS_TO:
                $sql = "SELECT {$link->fields}, {$mainTableAlias}.{$this->primaryKey} AS {$linkKey}" .
                    " FROM {$link->tableName}" .
                    " LEFT JOIN {$this->fullTableName}" .
                    " ON {$assocTableAlias}.{$link->assocPrimaryKey} = {$mainTableAlias}.{$link->foreignKey} ";
                if ($where) {
                	$sql .= ' WHERE ' . $where;
	            	if ($link->conditions) {
	            		$sql .= ' AND ' . $link->conditions;
	            	}
	            } elseif ($link->conditions) {
	            	$sql .= ' WHERE ' . $link->conditions;
	            }
                if ($link->sort) { $sql .= ' ORDER BY ' . $link->sort; }
                break;
            case MANY_TO_MANY:
                $sql = "SELECT {$link->fields}, {$mainTableAlias}.{$this->primaryKey} AS {$linkKey}" .
                    " FROM {$this->fullTableName}, {$link->joinTable}" .
                    " LEFT JOIN {$link->tableName}" .
                    " ON {$assocTableAlias}.{$link->assocPrimaryKey} = {$link->joinTable}.{$link->assocForeignKey}" .
                    " WHERE {$mainTableAlias}.{$this->primaryKey} = {$link->joinTable}.{$link->foreignKey}";
                if ($where) { $sql.= ' AND ' . $where; }
                if ($link->conditions) { $sql .= ' AND ' . $link->conditions; }
                if ($link->sort) { $sql .= ' ORDER BY ' . $link->sort; }
                break;
            default:
                continue;
            }
            $sql = str_replace('%AT%', $assocTableAlias, $sql);
            $joins[] = array($sql, $link, $mainTableAlias, $assocTableAlias);
        }
        return $joins;
    }

    /**
     * ������ѯ���������� WHERE �Ӿ�
     *
     * @param array $conditions
     *
     * @return string
     */
    function _prepareConditions($conditions) {
        if (is_null($conditions)) { return ''; }
        if (is_numeric($conditions)) {
            return "%MT%.{$this->primaryKey} = {$conditions}";
        }
        if (!is_array($conditions)) { return $conditions; }
        $where = array();
        foreach ($conditions as $key => $condition) {
            if (is_int($key)) {
                $condition = $this->_prepareConditions($condition);
                if ($condition != '') {
                    $where[] = $condition;
                }
            } else {
                $where[] = "%MT%.{$key} = " . $this->dbo->qstr($condition);
            }
        }
        return implode(' AND ', $where);
    }

    /**
     * ���¼�¼�� updated ���ֶ�
     *
     * @param array $row
     */
    function _setUpdatedTimeFields(& $row) {
        foreach ($this->updatedTimeFields as $af) {
            if (!isset($this->meta[$af])) { continue; }
            switch ($this->meta[$af]['simpleType']) {
            case 'T': // ����ʱ��
                // �����ݿ�������ȡʱ���ʽ
                $t = $this->dbo->dbTimeStamp(time());
                break;
            case 'I': // Unix ʱ���
                $t = time();
                break;
            default:
                continue;
            }
            $row[$this->meta[$af]['name']] = $t;
        }
    }

    /**
     * ���¼�¼�� created �� updated ���ֶ�
     *
     * @param array $row
     */
    function _setCreatedTimeFields(& $row) {
        $currentTime = time();
        $currentTimeStamp = $this->dbo->dbTimeStamp(time());
        foreach (array_merge($this->createdTimeFields, $this->updatedTimeFields) as $af) {
            if (!isset($this->meta[$af])) { continue; }
            $afn = $this->meta[$af]['name'];
            if (!empty($row[$afn])) { continue; }


            switch ($this->meta[$af]['simpleType']) {
            case 'T': // ����ʱ��
                // �����ݿ�������ȡʱ���ʽ
                $t = $currentTimeStamp;
                break;
            case 'I': // Unix ʱ���
                $t = $currentTime;
                break;
            default:
                continue;
            }
            $row[$afn] = $t;
        }
    }
}
