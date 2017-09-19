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
 * 定义 FLEA_Db_TableLink 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package DB
 * @version $Id: TableLink.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_TableLink 封装数据表之间的关联关系
 *
 * FLEA_Db_TableLink 是一个完全供 FleaPHP 内部使用的类，
 * 开发者不应该直接构造 FLEA_Db_TableLink 对象。
 *
 * @package DB
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_TableLink
{
    /**
     * 该连接的名字，用于检索指定的连接
     *
     * 同一个数据表的多个连接不能用同一个名字。如果定义连接时
     * 没有提供该参数，则使用 mappingName 选项作为连接的名字。
     *
     * @var string
     */
    var $name;

    /**
     * TableDataGateway 的名字
     *
     * @var string
     */
    var $tableClass;

    /**
     * 外键字段名
     *
     * @var string
     */
    var $foreignKey;

    /**
     * 关联表的主键字段名
     *
     * @var string
     */
    var $assocPrimaryKey;

    /**
     * 数据表名字（已经添加了全局数据表前缀）
     *
     * @var string
     */
    var $tableName;

    /**
     * 关联数据表结果在主表结果中的字段名
     *
     * @var string
     */
    var $mappingName;

    /**
     * 指示连接两个数据集的行时，是一对一连接还是一对多连接
     *
     * @var boolean
     */
    var $oneToOne;

    /**
     * FLEA_Db_TableLink 实例的类型
     *
     * @var enum
     */
    var $type;

    /**
     * 对关联表进行查询时使用的排序参数
     *
     * @var string
     */
    var $sort;

    /**
     * 对关联表进行查询时使用的条件参数
     *
     * @var string
     */
    var $conditions;

    /**
     * 对关联表进行查询时使用的查询条数限制
     *
     * @var mixed
     */
    var $limit;

    /**
     * 对关联表进行查询时要获取的关联表字段
     *
     * @var string
     */
    var $fields = '%AT%.*';

    /**
     * 当 enabled 为 false 时，TableDataGateway 的任何操作都不会处理该关联
     *
     * enabled 的优先级高于 linkRead、linkCreate、linkUpdate 和 linkRemove。
     *
     * @var boolean
     */
    var $enabled = true;

    /**
     * 指示是否在主表读取记录时也读取关联表的记录
     *
     * @var boolean
     */
    var $linkRead = true;

    /**
     * 指示是否在主表创建记录时也创建关联表的记录
     *
     * @var boolean
     */
    var $linkCreate = true;

    /**
     * 指示是否在主表更新记录时也更新关联表的记录
     *
     * @var boolean
     */
    var $linkUpdate = true;

    /**
     * 指示是否在主表删除记录时也删除关联表的记录
     *
     * @var boolean
     */
    var $linkRemove = true;

    /**
     * 当删除主表记录而不删除关联表记录时，用什么值填充关联表记录的外键字段
     *
     * @var mixed
     */
    var $linkRemoveFillValue = 0;

    /**
     * 必须设置的对象属性
     *
     * @var array
     */
    var $_req = array('tableClass', 'foreignKey', 'tableName',
        'assocPrimaryKey', 'mappingName');

    /**
     * 可选的参数
     *
     * @var array
     */
    var $_optional = array('name', 'sort', 'conditions', 'limit',
        'fields', 'enabled', 'linkRead', 'linkCreate', 'linkUpdate',
        'linkRemove', 'linkRemoveFillValue');

    /**
     * 构造函数
     *
     * @param array $args
     * @param enum $type
     *
     * @return FLEA_Db_TableLink
     */
    function FLEA_Db_TableLink($args, $type) {
        log_message('Construction FLEA_Db_TableLink(' . encode_url_args($args) . ', ' . $type . ')', 'debug');
        foreach ($this->_req as $key) {
            if (!isset($args[$key]) || $args[$key] == '') {
                load_class('FLEA_Db_Exception_MissingLinkOption');
                __THROW(new FLEA_Db_Exception_MissingLinkOption($key));
                return null;
            } else {
                $this->{$key} = $args[$key];
            }
        }
        foreach ($this->_optional as $key) {
            if (isset($args[$key])) {
                $this->{$key} = $args[$key];
            }
        }
        if ($this->type == HAS_ONE && $this->limit !== null) {
            $this->limit = 1;
        }
        $this->type = $type;
        $this->tableName = get_app_inf('dbTablePrefix') . $this->tableName;
    }

    /**
     * 根据 $link 和 $type 参数创建不同的 FLEA_Db_TableLink 对象
     *
     * @param array $link
     * @param enum $type
     *
     * @return mixed
     */
    function & createLink($link, $type) {
        static $map = array(
            HAS_ONE         => 'FLEA_Db_HasOneLink',
            BELONGS_TO      => 'FLEA_Db_BelongsToLink',
            HAS_MANY        => 'FLEA_Db_HasManyLink',
            MANY_TO_MANY    => 'FLEA_Db_ManyToManyLink',
        );

        if (!isset($map[$type])) {
            load_class('FLEA_Db_Exception_InvalidLinkType');
            __THROW(new FLEA_Db_Exception_InvalidLinkType($type));
            return false;
        }

        // 检查 $link 参数中是否已经提供了必须的选项
        if (!isset($link['tableClass'])) {
            load_class('FLEA_Db_Exception_MissingLinkOption');
            __THROW(new FLEA_Db_Exception_MissingLinkOption('tableClass'));
            return false;
        }

        if (check_reg($link['tableClass'])) {
            $tdg =& ref($link['tableClass']);
            $vars = get_object_vars($tdg);
        } else {
            load_class($link['tableClass']);
            $vars = get_class_vars($link['tableClass']);
        }

        // 对于可以自动获取的选项，尽量自动获取
        if (!isset($link['tableName'])) {
            $link['tableName'] = $vars['tableName'];
        }
        if (!isset($link['mappingName'])) {
            $link['mappingName'] = $link['tableClass'];
        }
        if (!isset($link['name'])) {
            $link['name'] = $link['mappingName'];
        }
        if (!isset($link['foreignKey'])) {
            if ($type == BELONGS_TO) {
                $link['foreignKey'] = $vars['primaryKey'];
            } else {
                $link['foreignKey'] = $this->primaryKey;
            }
        }
        if ($type == MANY_TO_MANY) {
            // 必须提供 joinTable 参数
            if (!isset($link['assocForeignKey'])) {
                $link['assocForeignKey'] = $vars['primaryKey'];
            }
        }
        $link['assocPrimaryKey'] = $vars['primaryKey'];

        $linkObj =& new $map[$type]($link, $type);
        return $linkObj;
    }
}

/**
 * FLEA_Db_HasOneLink 封装 has one 关系
 *
 * @package DB
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_HasOneLink extends FLEA_Db_TableLink
{
    var $oneToOne = true;
}

/**
 * FLEA_Db_BelongsToLink 封装 belongs to 关系
 *
 * @package DB
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_BelongsToLink extends FLEA_Db_TableLink
{
    var $oneToOne = true;
}

/**
 * FLEA_Db_HasManyLink 封装 has many 关系
 *
 * @package DB
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_HasManyLink extends FLEA_Db_TableLink
{
    var $oneToOne = false;
}

/**
 * FLEA_Db_ManyToManyLink 封装 many to many 关系
 *
 * @package DB
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_ManyToManyLink extends FLEA_Db_TableLink
{
    var $oneToOne = false;

    /**
     * 中间表的名字
     *
     * @var string
     */
    var $joinTable;

    /**
     * 中间表中保存关联表主键值的字段
     *
     * @var string
     */
    var $assocForeignKey;

    /**
     * 构造函数
     *
     * @param array $args
     *
     * @return FLEA_Db_ManyToManyLink
     */
    function FLEA_Db_ManyToManyLink($args, $type) {
        $this->_req[] = 'joinTable';
        $this->_req[] = 'assocForeignKey';
        parent::FLEA_Db_TableLink($args, $type);
        $this->joinTable = get_app_inf('dbTablePrefix') . $this->joinTable;
    }
}
