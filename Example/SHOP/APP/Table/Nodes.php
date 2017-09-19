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
 * ���� Table_Nodes ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: Nodes.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Table_Nodes �á��Ľ����ȸ������㷨�������ݿ��д洢��λ������ݣ�ͨ����˵�����޷��ࣩ
 *
 * ���ڡ��Ľ����ȸ������㷨��Ҫ�����нڵ㶼��Ψһһ�����ڵ���ӽڵ㡣
 * ���� Table_Nodes �ٶ�һ����Ϊ��_#_ROOT_NODE_#_���Ľڵ�ΪΨһ�ĸ��ڵ㡣
 *
 * Ӧ�ó����ڵ��� Table_Nodes::create() ������һ���ڵ�ʱ�����Զ�
 * �жϸ��ڵ��Ƿ���ڣ����������ڵ㡣
 *
 * ����Ӧ�ó�����˵����_#_ROOT_NODE_#_���ڵ��ǲ����ڵġ����ԣ�Ӧ�ó���
 * ���Դ���������ڵ� ID Ϊ 0 �ġ������ڵ㡱����Щ�����ڵ�ʵ���Ͼ���
 * ��_#_ROOT_NODE_#_���ڵ��ֱ���ӽڵ㡣
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Table_Nodes extends FLEA_Db_TableDataGateway
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'nodes';

    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey = 'node_id';

    /**
     * ���ڵ���
     *
     * @var string
     */
    var $_rootNodeName = '_#_ROOT_NODE_#_';

    /**
     * ���һ���ڵ㣬���ظýڵ�� ID
     *
     * @param array $node
     * @param int $parentId
     *
     * @return int
     */
    function create($node, $parentId) {
        $parentId = (int)$parentId;
        if ($parentId) {
            $parent = parent::find($parentId);
            if (!$parent) {
                // ָ���ĸ��ڵ㲻����
                load_class('Exception_NodeNotFound');
                __THROW(new Exception_NodeNotFound($parentId));
                return false;
            }
        } else {
            // ��� $parentId Ϊ 0 �� null���򴴽�һ�������ڵ�
            $parent = parent::find(array('name' => $this->_rootNodeName));
            if (!$parent) {
                // ������ڵ㲻���ڣ����Զ�����
                $parent = array(
                    'name' => $this->_rootNodeName,
                    'left_value' => 1,
                    'right_value' => 2,
                    'parent_id' => -1,
                );
                if (!parent::create($parent)) {
                    return false;
                }
            }
            // ȷ������ _#_ROOT_NODE_#_ ��ֱ���ֽڵ�� parent_id ��Ϊ 0
            $parent[$this->primaryKey] = 0;
        }

        // ���ݸ��ڵ����ֵ����ֵ��������
        $sql = "UPDATE {$this->fullTableName} SET left_value = left_value + 2 " .
               "WHERE left_value >= {$parent['right_value']}";
        $this->dbo->execute($sql);
        $sql = "UPDATE {$this->fullTableName} SET right_value = right_value + 2 " .
               "WHERE right_value >= {$parent['right_value']}";
        $this->dbo->execute($sql);

        // �����½ڵ��¼
        $node = array(
            'name' => $node['name'],
            'left_value' => $parent['right_value'],
            'right_value' => $parent['right_value'] + 1,
            'parent_id' => $parent[$this->primaryKey],
        );
        return parent::create($node);
    }

    /**
     * ���½ڵ���Ϣ
     *
     * @param array $node
     *
     * @return boolean
     */
    function update($node) {
        unset($node['left_value']);
        unset($node['right_value']);
        unset($node['parent_id']);
        return parent::update($node);
    }

    /**
     * ɾ��һ���ڵ㼰���ӽڵ���
     *
     * @param array $node
     *
     * @return boolean
     */
    function remove($node) {
        $span = $node['right_value'] - $node['left_value'] + 1;
        $sql = "DELETE FROM {$this->fullTableName} " .
               "WHERE left_value >= {$node['left_value']} " .
               "AND right_value <= {$node['right_value']}";
        if (!$this->dbo->execute($sql)) {
            return false;
        }

        $sql = "UPDATE {$this->fullTableName} " .
               "SET left_value = left_value - {$span} " .
               "WHERE left_value > {$node['right_value']}";
        if (!$this->dbo->execute($sql)) {
            return false;
        }

        $sql = "UPDATE {$this->fullTableName} " .
               "SET right_value = right_value - {$span} " .
               "WHERE right_value > {$node['right_value']}";
        if (!$this->dbo->execute($sql)) {
            return false;
        }

        return true;
    }

    /**
     * ɾ��һ���ڵ㼰���ӽڵ���
     *
     * @param int $nodeId
     *
     * @return boolean
     */
    function removeByPkv($nodeId) {
        $node = parent::find((int)$nodeId);
        if (!$node) {
            load_class('Exception_NodeNotFound');
            __THROW(new Exception_NodeNotFound($nodeId));
            return false;
        }

        return $this->remove($node);
    }

    /**
     * ���ظ��ڵ㵽ָ���ڵ�·���ϵ����нڵ�
     *
     * ���صĽ����������_#_ROOT_NODE_#_�����ڵ�����ڵ�ͬ����������ڵ㡣
     * �������һ����ά���飬������ array_to_tree() ����ת��Ϊ��νṹ�����ͣ���
     *
     * @param array $node
     *
     * @return array
     */
    function getPath($node) {
        $conditions = "left_value < {$node['left_value']} AND " .
                      "right_value > {$node['right_value']}";
        $sort = 'left_value ASC';
        $rowset = $this->findAll($conditions, $sort);
        if (is_array($rowset)) {
            array_shift($rowset);
        }
        return $rowset;
    }

    /**
     * ����ָ���ڵ��ֱ���ӽڵ�
     *
     * @param array $node
     *
     * @return array
     */
    function getSubNodes($node) {
        $conditions = "parent_id = {$node[$this->primaryKey]}";
        $sort = 'left_value ASC';
        return $this->findAll($conditions, $sort);
    }

    /**
     * ����ָ���ڵ�Ϊ���������ӽڵ���
     *
     * @param array $node
     *
     * @return array
     */
    function getSubTree($node) {
        $conditions = "left_value BETWEEN {$node['left_value']} " .
                      "AND {$node['right_value']}";
        $sort = 'left_value ASC';
        return $this->findAll($conditions, $sort);
    }

    /**
     * ��ȡָ���ڵ�ͬ��������нڵ�
     *
     * @param array $node
     *
     * @return array
     */
    function getCurrentLevelNodes($node) {
        $conditions = "parent_id = {$node['parent_id']}";
        $sort = 'left_value ASC';
        return $this->findAll($conditions, $sort);
    }

    /**
     * ȡ�����нڵ�
     *
     * @return array
     */
    function getAllNodes() {
        return parent::findAll('left_value > 1', 'left_value ASC');
    }

    /**
     * ��ȡ���ж����ڵ㣨�� _#_ROOT_NODE_#_ ��ֱ���ӽڵ㣩
     *
     * @return array
     */
    function getAllTopNodes() {
        $conditions = "parent_id = 0";
        $sort = 'left_value ASC';
        return $this->findAll($conditions, $sort);
    }

    /**
     * ���������ӽڵ������
     *
     * @param array $node
     *
     * @return int
     */
    function calcAllChildCount($node) {
        return intval(($node['right_value'] - $node['left_value'] - 1) / 2);
    }
}
