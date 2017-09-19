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
 * 定义 FLEA_Db_TableDataGateway 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package DB
 * @version $Id: TableDataGateway.php 683 2007-01-05 16:27:22Z dualface $
 */

// {{{ constants
/**
 * 虚拟关联字段名
 */
if (!defined('LINK_KEY')) {
    define('LINK_KEY', 'ref__row__id');
}

/**
 * 四种关联
 */
define('HAS_ONE',       1);
define('BELONGS_TO',    2);
define('HAS_MANY',      3);
define('MANY_TO_MANY',  4);
// }}}

/**
 * FLEA_Db_TableDataGateway 类封装了数据表的 CRUD 操作
 *
 * 针对每个数据表，开发者应该从 FLEA_Db_TableDataGateway 派生自己的类。
 * 并通过添加方法来封装针对该数据表的更复杂的数据库操作。
 *
 * @package DB
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.1
 */
class FLEA_Db_TableDataGateway
{
    /**
     * 不包含前缀的数据表名
     *
     * 如果在派生类中没有覆盖此变量，则以派生类的类名作为数据表名。
     *
     * @var string
     */
    var $tableName = null;

    /**
     * 进行过标准化以后的数据表名称，包含前缀
     *
     * @var string
     */
    var $fullTableName = null;

    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey = null;

    /**
     * 指示在保存数据到数据库（创建记录以及更新记录）时是否自动验证数据
     *
     * @var boolean
     */
    var $autoValidation = true;

    /**
     * 定义一对一关联
     *
     * 1、外键放置在关联表中；
     * 2、保存时如果有关联对象，则自动创建或更新关联表的记录；
     * 3、删除主表记录时自动删除关联记录。
     *
     * 示例：
     * 当前表为 users，用于存储用户账户。而每个用户账户有且只有一个对应的个人信息（profile）记录。
     *
     * 格式一：
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
     * 在上面的格式中，foreignKey 表示在关联表中用什么字段存储对主表的主键引用。
     * mappingName 表示在主表的返回结果中，以什么名字保存关联表的数据。
     * 如果不提供 mappingName 参数，则假定使用 tableClass。
     *
     * 格式二：
     * <code>
     * class Users
     * {
     *     var $hasOne = 'Profiles';
     * }
     * </code>
     *
     * 格式二是一种简化写法。foreignKey 字段名将和主表的主键字段名名相同。
     *
     * @var array
     */
    var $hasOne = null;

    /**
     * 定义从属关联
     *
     * 1、外键放置在主表中；
     * 2、保存时不会自动更新关联表的记录；
     * 3、删除时也不会更新关联表的记录。
     *
     * 示例：
     * 多个文章都属于某一个栏目。
     *
     * 格式一：
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
     * 在上面的格式中，foreignKey 表示在当前表中用什么字段存储对关联表的主键引用。
     * mappingName 表示在主表的返回结果中，以什么名字保存关联表的数据。
     * 如果不提供 mappingName 参数，则假定使用 tableClass。
     *
     * 格式二：
     * <code>
     * class Articles
     * {
     *     var $belongsTo = 'Columns';
     * }
     * </code>
     *
     * 格式二是一种简化写法。foreignKey 字段名将和关联表的主键字段名相同。
     *
     * @var array
     */
    var $belongsTo = null;

    /**
     * 定义一对多关联
     *
     * 1、外键保存在关联表中；
     * 2、保存时自动更新关联表的记录；
     * 3、删除主表记录时自动删除关联记录。
     *
     * 示例：
     * 每个用户（user）有多张订单 order。
     *
     * 格式一：
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
     * 在一对多关系中，当前表并不包含对关联表的主键引用。
     * 而是在关联表中保存对当前表的主键引用。
     *
     * 在上面的格式中，foreignKey 指示在关联表中用什么字段存储对当前表的主键引用。
     * mappingName 表示在主表的返回结果中，以什么名字保存关联表的数据。
     * 如果不提供 mappingName 参数，则假定使用 tableClass。
     *
     * 格式二：
     * <code>
     * class Users
     * {
     *     var $hasMany = 'Orders';
     * }
     * </code>
     *
     * 简化写法中，foreignKey 字段名将和当前表的主键字段名相同。
     *
     * @var array
     */
    var $hasMany = null;

    /**
     * 定义多对多关联
     *
     * 1、外键保存在中间表里面；
     * 2、保存时自动更新中间表；
     * 3、删除主表记录时自动删除中间表的相关记录。
     *
     * 示例：
     * 每个成员（member）可以拥有多个角色（role），而每个角色也可以指定给多个成员。
     *
     * 格式一：
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
     * 在多对多关系中，当前表并不包含对关联表的主键引用。
     * 而是在一个中间表里面保存对当前表和关联表的主键引用。
     *
     * 在上面的格式中，joinTable 表示中间表的名字。foreignKey 和
     * assocforeignKey 分别表示在中间表里面用什么字段存储对主表和
     * 关联表主键字段的引用。
     *
     * mappingName 表示在主表的返回结果中，以什么名字保存关联表的数据。
     * 如果不提供 mappingName 参数，则假定使用 tableClass。
     *
     * 格式二：
     * <code>
     * class Members
     * {
     *     var $manyToMany = 'Roles';
     * }
     * </code>
     *
     * 简化写法中，foreignKey 字段名将和当前表的主键字段名相同。
     * assocforeignKey 字段名称则和关联数据表的主键字段名相同。
     * 而中间表名称将用 FLEA_Db_TableDataGateway::getMidtableName() 方法计算。
     *
     * @var array
     */
    var $manyToMany = null;

    /**
     * 指示是否自动建立表间关联，并在查询数据时获取关联表的数据
     *
     * @var boolean
     */
    var $autoLink = true;

    /**
     * 数据库访问对象
     *
     * @var FLEA_Db_SDBO
     */
    var $dbo = null;

    /**
     * 当前数据表的元数据
     *
     * @var array
     */
    var $meta = null;

    /**
     * 存储关联信息
     *
     * $this->links 是一个数组，数组中保存 TableLink 对象。
     *
     * @var array
     */
    var $links = array();

    /**
     * 用于数据验证的 Validation 对象
     *
     * @var FLEA_Helper_Validation
     */
    var $validation = null;

    /**
     * 创建记录时，要自动填入当前 timestamp 的字段
     *
     * @var array
     */
    var $createdTimeFields = array('CREATED', 'CREATED_ON', 'CREATED_AT');

    /**
     * 更新记录时，要自动填入当前 timestamp 的字段
     *
     * @var array
     */
    var $updatedTimeFields = array('UPDATED', 'UPDATED_ON', 'UPDATED_AT');

    /**
     * 产生序列时，保存序列的数据表名称模式
     *
     * @var string
     */
    var $sequenceNamePattern = 'seq_%s';

    /**
     * 最后一次对数据进行验证的结果
     *
     * @var mixed
     */
    var $_lastValidation = null;

    /**
     * 构造 FLEA_Db_TableDataGateway 实例
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

        // 初始化验证服务对象
        if ($this->autoValidation && $noAutoInit !== true) {
            $this->validation =& get_singleton(get_app_inf('dbValidationProvider'));
        }

        // 初始化
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
     * 设置 FLEA_Db_SDBO
     *
     * @param FLEA_Db_SDBO $dbo
     */
    function setSDBO(& $dbo) {
        // 连接到数据库
        $this->dbo =& $dbo;
        if (!$this->dbo->conn) {
            $this->dbo->connect();
        }
        // 标准化数据表名称
        $this->fullTableName = $this->dbo->qtable($this->fullTableName);
        // 取得数据表的元数据
        $this->meta = $this->dbo->metaColumns($this->fullTableName);
        // 如果需要，猜测主键字段名
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
     * 以数组方式返回符合条件的第一条记录及所有关联的数据，查询没有结果返回 false
     *
     * 用法：
     * <code>
     *   $order = $ordersTable->find($conditions);
     * </code>
     *
     * $conditions 参数的用法很多，列表如下：
     * <code>
     *   // 整数将作为主键值进行查询
     *   $conditions = 23;
     *
     *   // 字符串将作为自定义条件进行查询
     *   $conditions = "name = 'dualface'";
     *
     *   // 数组将根据每个元素的情况进行处理
     *   // 多个元素将用 AND 布尔运算符连接。
     *   // 下面的条件等同于 name <> 'dualface' AND sex = 'male'
     *   $conditions = array("name <> 'dualface'", "sex = 'male'");
     *   // 元素也可以是数组或者字符串
     *   $conditions = array(
     *       "born = '1977/10/24'",
     *       array('sex' => 'sex'),
     *   );
     * </code>
     *
     * 但使用过于复杂的查询数组并不是一个好主意。
     * 在可能的情况下，应该尽可能使用字符串作为查询条件。
     * 因为对于字符串条件不会做任何额外处理，可以获得最高的处理速度。
     *
     * 当然，使用数组做查询条件，可以便于多个条件组合，
     * 并且让 TableDataGateway 自动处理字符串转义等问题。
     *
     * @param mixed $conditions 查询条件
     * @param string $sort 排序
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
     * 查询所有符合条件的记录及相关数据，返回一个 FLEA_Db_RowSet 对象
     *
     * 如果关联表的数据量很大，那么可以在使用 findAll() 查询之前，设置
     * 表数据入口对象的 $autoLink 成员变量为 false 来阻止对关联表的查询。
     *
     * @param mixed $conditions 查询条件
     * @param string $sort
     * @param mixed $limit
     * @param string $fields
     *
     * @return array
     */
    function findAll($conditions = null, $sort = null, $limit = null, $fields = '*') {
        // 处理查询条件
        $where = $this->_prepareConditions($conditions);
        if ($where) {
            $whereby = ' WHERE ' . $where;
        } else {
            $whereby = '';
        }
        // 处理排序
        if ($sort != '') {
            $orderby = ' ORDER BY ' . $sort;
        } else {
            $orderby = '';
        }
        // 处理 $limit
        if (is_array($limit)) {
            list($length, $offset) = $limit;
        } else {
            $length = $limit;
            $offset = null;
        }

        // 查询当前表
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
         * 为所有关联数据表做查询准备
         *
         * $this->_getJoinsSql() 返回一个二维数组。每个行包含两个元素：
         *   $join[0] 查询语句；
         *   $join[1] TableLink 对象实例；
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
     * 返回具有指定字段值的第一条记录
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
     * 返回具有指定字段值的所有记录
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
     * 直接使用 sql 语句获取记录
     *
     * 该方法不会处理关联数据表。
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
     * 返回符合条件的记录总数
     *
     * @param mixed $conditions
     * @param string $fields 统计记录时涉及的字段
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
     * 保存数据到数据库
     *
     * 为了提高性能，应该明确调用 create() 方法来创建新记录，
     * 调用 update() 方法来更新现有记录。
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
     * 替换一条现有记录或插入新记录，返回记录的主键值
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
     * 更新一条现有的记录
     *
     * @param array $row
     *
     * @return mixed
     */
    function update($row) {
    	// 事件 callback
        if (method_exists($this, '_beforeUpdate')) {
            if (!$this->_beforeUpdate($row)) {
                return false;
            }
        }

        // 处理主键
        if (!isset($row[$this->primaryKey])) {
            load_class('FLEA_Db_Exception_MissingPrimaryKey');
            __THROW(new FLEA_Db_Exception_MissingPrimaryKey($this->primaryKey));
            return false;
        }

        // 自动处理 updatedTimeFields 字段
        $this->_setUpdatedTimeFields($row);;

        // 自动验证数据
        if ($this->autoValidation) {
            $result = $this->checkRowData($row, true);
            if (!empty($result)) {
                load_class('FLEA_Exception_ValidationFailed');
                __THROW(new FLEA_Exception_ValidationFailed($result, $row));
                return false;
            }
        }

		// 事件 callback
        if (method_exists($this, '_beforeUpdateDb')) {
            if (!$this->_beforeUpdateDb($row)) {
                return false;
            }
        }

        // 生成 SQL 语句
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
            // 处理关联数据表
            foreach ($this->links as $link) {
                /* @var $link FLEA_Db_TableLink */
                if (!$link->enabled || !isset($row[$link->mappingName])
                        || !is_array($row[$link->mappingName])) { continue; }
                $assoc = $row[$link->mappingName];
                switch ($link->type) {
                case MANY_TO_MANY:
                    /**
                     * 对于多对多关联，自动更新中间数据表
                     *
                     * 在更新多对多关联时，要求提交的记录数据包含中间表的信息。
                     * 例如：
                     *     users 表保存用户信息，roles 表保存角色信息
                     *     那么 roles_users 中间表就是保存两个表的关联信息。
                     *
                     * 在更新多对多关联时，记录中应该包含一个特定的字段，字段名
                     * 为该关联的 mappingName 参数。
                     *
                     * 字段内容是一个一维数组，里面每一个项目都是关联表的主键值。
                     */
                    /* @var $link FLEA_Db_ManyToManyLink */
                    $sql = 'SELECT ' . $link->assocForeignKey .
                           ' FROM ' . $link->joinTable . ' WHERE ' .
                           $link->foreignKey . ' = ' . $qpk;
                    // 首先取出现有的关联信息，然后确定要删除的关联信息和要添加的关联信息
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
                     * 对于 HAS_ONE 关联，更新记录时自动更新关联记录的内容
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
                     * 对于 HAS_MANY 关联，更新记录时自动更新关联记录的内容
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

		// 事件 callback
        if (method_exists($this, '_afterUpdateDb')) {
        	$this->_afterUpdateDb($row);
        }

        return true;
    }

    /**
     * 更新符合条件的记录，返回更新的记录总数
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
     * 更新记录的指定字段，返回更新的记录总数
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
     * 增加指定字段的计数值，返回更新的记录总数
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
     * 减小指定字段的计数值，返回更新的记录总数
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
     * 插入一条新记录，返回新记录的主键值
     *
     * @param array $row
     *
     * @return mixed
     */
    function create($row) {
    	// 事件 callback
        if (method_exists($this, '_beforeCreate')) {
            if (!$this->_beforeCreate($row)) {
                return false;
            }
        }

        // 自动处理 createdTimeFields 和 updatedTimeFields 字段
        $this->_setCreatedTimeFields($row);

        // 处理主键
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
            // 尝试自动生成一个新的主键值
            if (!isset($row[$this->primaryKey])) {
                $row[$this->primaryKey] = $this->newInsertId();
            }
        }

        // 自动验证数据
        if ($this->autoValidation) {
            $result = $this->checkRowData($row);
            if (!empty($result)) {
                load_class('FLEA_Exception_ValidationFailed');
                __THROW(new FLEA_Exception_ValidationFailed($result, $row));
                return false;
            }

            // 填充默认值和处理 NULL
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

    	// 事件 callback
        if (method_exists($this, '_beforeCreateDb')) {
            if (!$this->_beforeCreateDb($row)) {
                return false;
            }
        }

        // 生成 SQL 语句
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
            // 处理关联数据表
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

    	// 事件 callback
    	if (method_exists($this, '_afterCreate')) {
    		$this->_afterCreate($row, $insertId);
    	}

        return $insertId;
    }

    /**
     * 删除指定主键得记录
     *
     * 为了提高处理性能，删除记录时不会处理任何关联表。
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
     * 根据主键值删除记录
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
            // 处理关联数据表
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
                     * 对于 HAS_ONE 和 HAS_MANY 关联，分为两种情况处理
                     *
                     * 当 $link->linkRemove 为 true 时，直接删除关联表中的关联数据
                     * 否则更新关联数据的外键值为 $link->linkRemoveFillValue
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
     * 删除符合条件的记录，返回删除的记录数量
     *
     * 删除记录时，将自动更新关联数据表。
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
     * 删除所有记录
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
     * 清除与其他数据表的所与关联
     */
    function clearLink() {
        $this->links = array();
    }

    /**
     * 建立与其他数据表入口对象之间的关联
     */
    function relink() {
        $this->createLink($this->hasOne,     HAS_ONE);
        $this->createLink($this->belongsTo,  BELONGS_TO);
        $this->createLink($this->hasMany,    HAS_MANY);
        $this->createLink($this->manyToMany, MANY_TO_MANY);
    }

    /**
     * 获取指定表数据入口和类型的关联对象
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
     * 获取指定名字的关联对象
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
     * 建立关联
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
     * 对数据进行验证
     *
     * 派生类可以覆盖此方法，以便进行附加的验证。
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
     * 返回最后一次数据验证的结果
     *
     * @return mixed
     */
    function getLastValidation() {
        return $this->_lastValidation;
    }

    /**
     * 返回当前数据表的下一个插入 ID
     *
     * @return mixed
     */
    function newInsertId() {
        return $this->dbo->nextId(sprintf($this->sequenceNamePattern, $this->tableName));
    }

    /**
     * 创建多个数据表入口对象的联合查询语句
     *
     * 返回一个二维数组：
     *   $join[0] 查询语句；
     *   $join[1] TableLink 对象；
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
     * 分析查询条件，返回 WHERE 子句
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
     * 更新记录的 updated 等字段
     *
     * @param array $row
     */
    function _setUpdatedTimeFields(& $row) {
        foreach ($this->updatedTimeFields as $af) {
            if (!isset($this->meta[$af])) { continue; }
            switch ($this->meta[$af]['simpleType']) {
            case 'T': // 日期时间
                // 由数据库驱动获取时间格式
                $t = $this->dbo->dbTimeStamp(time());
                break;
            case 'I': // Unix 时间戳
                $t = time();
                break;
            default:
                continue;
            }
            $row[$this->meta[$af]['name']] = $t;
        }
    }

    /**
     * 更新记录的 created 和 updated 等字段
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
            case 'T': // 日期时间
                // 由数据库驱动获取时间格式
                $t = $currentTimeStamp;
                break;
            case 'I': // Unix 时间戳
                $t = $currentTime;
                break;
            default:
                continue;
            }
            $row[$afn] = $t;
        }
    }
}
