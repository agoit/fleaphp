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
 * ���� FLEA_Db_TableLink ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package DB
 * @version $Id: TableLink.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_TableLink ��װ���ݱ�֮��Ĺ�����ϵ
 *
 * FLEA_Db_TableLink ��һ����ȫ�� FleaPHP �ڲ�ʹ�õ��࣬
 * �����߲�Ӧ��ֱ�ӹ��� FLEA_Db_TableLink ����
 *
 * @package DB
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_TableLink
{
    /**
     * �����ӵ����֣����ڼ���ָ��������
     *
     * ͬһ�����ݱ�Ķ�����Ӳ�����ͬһ�����֡������������ʱ
     * û���ṩ�ò�������ʹ�� mappingName ѡ����Ϊ���ӵ����֡�
     *
     * @var string
     */
    var $name;

    /**
     * TableDataGateway ������
     *
     * @var string
     */
    var $tableClass;

    /**
     * ����ֶ���
     *
     * @var string
     */
    var $foreignKey;

    /**
     * ������������ֶ���
     *
     * @var string
     */
    var $assocPrimaryKey;

    /**
     * ���ݱ����֣��Ѿ������ȫ�����ݱ�ǰ׺��
     *
     * @var string
     */
    var $tableName;

    /**
     * �������ݱ������������е��ֶ���
     *
     * @var string
     */
    var $mappingName;

    /**
     * ָʾ�����������ݼ�����ʱ����һ��һ���ӻ���һ�Զ�����
     *
     * @var boolean
     */
    var $oneToOne;

    /**
     * FLEA_Db_TableLink ʵ��������
     *
     * @var enum
     */
    var $type;

    /**
     * �Թ�������в�ѯʱʹ�õ��������
     *
     * @var string
     */
    var $sort;

    /**
     * �Թ�������в�ѯʱʹ�õ���������
     *
     * @var string
     */
    var $conditions;

    /**
     * �Թ�������в�ѯʱʹ�õĲ�ѯ��������
     *
     * @var mixed
     */
    var $limit;

    /**
     * �Թ�������в�ѯʱҪ��ȡ�Ĺ������ֶ�
     *
     * @var string
     */
    var $fields = '%AT%.*';

    /**
     * �� enabled Ϊ false ʱ��TableDataGateway ���κβ��������ᴦ��ù���
     *
     * enabled �����ȼ����� linkRead��linkCreate��linkUpdate �� linkRemove��
     *
     * @var boolean
     */
    var $enabled = true;

    /**
     * ָʾ�Ƿ��������ȡ��¼ʱҲ��ȡ������ļ�¼
     *
     * @var boolean
     */
    var $linkRead = true;

    /**
     * ָʾ�Ƿ�����������¼ʱҲ����������ļ�¼
     *
     * @var boolean
     */
    var $linkCreate = true;

    /**
     * ָʾ�Ƿ���������¼�¼ʱҲ���¹�����ļ�¼
     *
     * @var boolean
     */
    var $linkUpdate = true;

    /**
     * ָʾ�Ƿ�������ɾ����¼ʱҲɾ��������ļ�¼
     *
     * @var boolean
     */
    var $linkRemove = true;

    /**
     * ��ɾ�������¼����ɾ���������¼ʱ����ʲôֵ���������¼������ֶ�
     *
     * @var mixed
     */
    var $linkRemoveFillValue = 0;

    /**
     * �������õĶ�������
     *
     * @var array
     */
    var $_req = array('tableClass', 'foreignKey', 'tableName',
        'assocPrimaryKey', 'mappingName');

    /**
     * ��ѡ�Ĳ���
     *
     * @var array
     */
    var $_optional = array('name', 'sort', 'conditions', 'limit',
        'fields', 'enabled', 'linkRead', 'linkCreate', 'linkUpdate',
        'linkRemove', 'linkRemoveFillValue');

    /**
     * ���캯��
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
     * ���� $link �� $type ����������ͬ�� FLEA_Db_TableLink ����
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

        // ��� $link �������Ƿ��Ѿ��ṩ�˱����ѡ��
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

        // ���ڿ����Զ���ȡ��ѡ������Զ���ȡ
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
            // �����ṩ joinTable ����
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
 * FLEA_Db_HasOneLink ��װ has one ��ϵ
 *
 * @package DB
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_HasOneLink extends FLEA_Db_TableLink
{
    var $oneToOne = true;
}

/**
 * FLEA_Db_BelongsToLink ��װ belongs to ��ϵ
 *
 * @package DB
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_BelongsToLink extends FLEA_Db_TableLink
{
    var $oneToOne = true;
}

/**
 * FLEA_Db_HasManyLink ��װ has many ��ϵ
 *
 * @package DB
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_HasManyLink extends FLEA_Db_TableLink
{
    var $oneToOne = false;
}

/**
 * FLEA_Db_ManyToManyLink ��װ many to many ��ϵ
 *
 * @package DB
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_ManyToManyLink extends FLEA_Db_TableLink
{
    var $oneToOne = false;

    /**
     * �м�������
     *
     * @var string
     */
    var $joinTable;

    /**
     * �м���б������������ֵ���ֶ�
     *
     * @var string
     */
    var $assocForeignKey;

    /**
     * ���캯��
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
