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
 * 定义 Model_ProductClasses 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductClasses.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Model_ProductClasses 封装对商品分类的所有操作
 *
 * Model_ProductClasses 为应用程序提供一个简单、清晰的，操作分类的接口。分类数据的具体操作
 * 都是由 Model_ProductClasses 聚合的 Table_ProductClasses 对象来处理。
 *
 * 对于较为复杂的应用程序，将常见的 Model 分割为 Model + TableDataGateway 两部分，可以让
 * 应用程序获得更清晰的结构和代码。便于后期维护和扩展。
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Model_ProductClasses
{
    /**
     * 提供分类数据库表操作的对象
     *
     * @var Table_ProductClasses
     */
    var $_tbNodes;

    /**
     * 构造函数
     *
     * @return Model_ProductClasses
     */
    function Model_ProductClasses() {
        $this->_tbNodes =& get_singleton('Table_ProductClasses');
    }

    /**
     * 取得所有类别
     *
     * @return array
     */
    function getAllClasses() {
        return $this->_tbNodes->getAllNodes();
    }

    /**
     * 取得所有顶级分类
     *
     * @return array
     */
    function getAllTopClasses() {
        return $this->_tbNodes->getAllTopNodes();
    }

    /**
     * 取得指定 ID 的分类
     *
     * @param int $classId
     *
     * @return array
     */
    function getClass($classId) {
        return $this->_tbNodes->find((int)$classId);
    }

    /**
     * 返回顶级分类到指定分类路径上的所有分类
     *
     * @param array $class
     *
     * @return array
     */
    function getSubTree($class) {
        return $this->_tbNodes->getSubTree($class);
    }

    /**
     * 取得指定分类到其顶级分类的完整路径
     *
     * @param array $class
     *
     * @return array
     */
    function getPath($class) {
        return $this->_tbNodes->getPath($class);
    }

    /**
     * 取得指定分类的所有直接子分类
     *
     * @param array $class
     *
     * @return array
     */
    function getSubClasses($class) {
        return $this->_tbNodes->getSubNodes($class);
    }

    /**
     * 创建新分类，并返回新分类的 ID
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
     * 更新分类信息
     *
     * @param array $class
     *
     * @return boolean
     */
    function updateClass($class) {
        return $this->_tbNodes->update($class);
    }

    /**
     * 删除指定的分类及其子分类树
     *
     * @param array $class
     *
     * @return boolean
     */
    function removeClass($class) {
        return $this->_tbNodes->remove($class);
    }

    /**
     * 删除指定 ID 的分类及其子分类树
     *
     * @param int $classId
     *
     * @return boolean
     */
    function removeClassById($classId) {
        return $this->_tbNodes->removeByPkv($classId);
    }

    /**
     * 获取指定分类同级别的所有分类
     *
     * @param array $node
     *
     * @return array
     */
    function getCurrentLevelClasses($class) {
        return $this->_tbNodes->getCurrentLevelNodes($class);
    }

    /**
     * 计算所有子分类的总数
     *
     * @param array $class
     *
     * @return int
     */
    function calcAllChildCount($class) {
        return $this->_tbNodes->calcAllChildCount($class);
    }
}
