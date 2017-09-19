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
 * ���� FLEA_Helper_Iterator ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: Iterator.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Helper_Iterator ʵ����һ���򵥵ĵ�����
 *
 * @package Helper
 */
class FLEA_Helper_Iterator
{
    /**
     * �ڲ�����
     *
     * @var array
     */
    var $_data;

    /**
     * ָʾ��ǰ����λ��
     *
     * @var boolean
     */
    var $_first = true;

    /**
     * ��¼����
     *
     * @var int
     */
    var $_count;

    /**
     * ���캯��
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
     * ������һ��Ԫ��
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
     * ��ֵ����λ��
     */
    function rewind() {
        reset($this->_data);
        $this->_first = true;
    }

    /**
     * ���ؼ�¼����
     *
     * @return int
     */
    function count() {
        return $this->_count;
    }
}
