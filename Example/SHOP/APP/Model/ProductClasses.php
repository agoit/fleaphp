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
 * ���� Model_ProductClasses ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductClasses.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Model_ProductClasses ��װ����Ʒ��������в���
 *
 * Model_ProductClasses ΪӦ�ó����ṩһ���򵥡������ģ���������Ľӿڡ��������ݵľ������
 * ������ Model_ProductClasses �ۺϵ� Table_ProductClasses ����������
 *
 * ���ڽ�Ϊ���ӵ�Ӧ�ó��򣬽������� Model �ָ�Ϊ Model + TableDataGateway �����֣�������
 * Ӧ�ó����ø������Ľṹ�ʹ��롣���ں���ά������չ��
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_ProductClasses
{
    /**
     * �ṩ�������ݿ������Ķ���
     *
     * @var Table_ProductClasses
     */
    var $_tbNodes;

    /**
     * ���캯��
     *
     * @return Model_ProductClasses
     */
    function Model_ProductClasses() {
        $this->_tbNodes =& get_singleton('Table_ProductClasses');
    }

    /**
     * ȡ���������
     *
     * @return array
     */
    function getAllClasses() {
        return $this->_tbNodes->getAllNodes();
    }

    /**
     * ȡ�����ж�������
     *
     * @return array
     */
    function getAllTopClasses() {
        return $this->_tbNodes->getAllTopNodes();
    }

    /**
     * ȡ��ָ�� ID �ķ���
     *
     * @param int $classId
     *
     * @return array
     */
    function getClass($classId) {
        return $this->_tbNodes->find((int)$classId);
    }

    /**
     * ���ض������ൽָ������·���ϵ����з���
     *
     * @param array $class
     *
     * @return array
     */
    function getSubTree($class) {
        return $this->_tbNodes->getSubTree($class);
    }

    /**
     * ȡ��ָ�����ൽ�䶥�����������·��
     *
     * @param array $class
     *
     * @return array
     */
    function getPath($class) {
        return $this->_tbNodes->getPath($class);
    }

    /**
     * ȡ��ָ�����������ֱ���ӷ���
     *
     * @param array $class
     *
     * @return array
     */
    function getSubClasses($class) {
        return $this->_tbNodes->getSubNodes($class);
    }

    /**
     * �����·��࣬�������·���� ID
     *
     * @param array $class
     * @param int $parentId
     *
     * @return int
     */
    function createClass($class, $parentId) {
        return $this->_tbNodes->create($class, $parentId);
    }

    /**
     * ���·�����Ϣ
     *
     * @param array $class
     *
     * @return boolean
     */
    function updateClass($class) {
        return $this->_tbNodes->update($class);
    }

    /**
     * ɾ��ָ���ķ��༰���ӷ�����
     *
     * @param array $class
     *
     * @return boolean
     */
    function removeClass($class) {
        return $this->_tbNodes->remove($class);
    }

    /**
     * ɾ��ָ�� ID �ķ��༰���ӷ�����
     *
     * @param int $classId
     *
     * @return boolean
     */
    function removeClassById($classId) {
        return $this->_tbNodes->removeByPkv($classId);
    }

    /**
     * ��ȡָ������ͬ��������з���
     *
     * @param array $node
     *
     * @return array
     */
    function getCurrentLevelClasses($class) {
        return $this->_tbNodes->getCurrentLevelNodes($class);
    }

    /**
     * ���������ӷ��������
     *
     * @param array $class
     *
     * @return int
     */
    function calcAllChildCount($class) {
        return $this->_tbNodes->calcAllChildCount($class);
    }
}
