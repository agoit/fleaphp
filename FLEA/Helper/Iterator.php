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
 * 定义 FLEA_Helper_Iterator 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Helper
 * @version $Id: Iterator.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Helper_Iterator 实现了一个简单的迭代子
 *
 * @package Helper
 */
class FLEA_Helper_Iterator
{
    /**
     * 内部数据
     *
     * @var array
     */
    var $_data;

    /**
     * 指示当前迭代位置
     *
     * @var boolean
     */
    var $_first = true;

    /**
     * 记录总数
     *
     * @var int
     */
    var $_count;

    /**
     * 构造函数
     *
     * @param array $data
     */
    function FLEA_Helper_Iterator(& $data) {
        if (!is_array($data)) {
            load_class('FLEA_Exception_TypeMismatch');
            __THROW(new FLEA_Exception_TypeMismatch('$data', 'array', gettype($data)));
            return;
        }
        $this->_data =& $data;
        reset($this->_data);
        $this->_count = count($data);
    }

    /**
     * 迭代下一个元素
     *
     * @return mixed
     */
    function & next() {
        if ($this->_first) {
            $this->_first = false;
        } else {
            next($this->_data);
        }
        $key = key($this->_data);
        if (array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        } else {
            $result = false;
            return $result;
        }
    }

    /**
     * 重值迭代位置
     */
    function rewind() {
        reset($this->_data);
        $this->_first = true;
    }

    /**
     * 返回记录总数
     *
     * @return int
     */
    function count() {
        return $this->_count;
    }
}
