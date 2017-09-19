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
 * ���� FLEA_Exception_NotImplemented �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: NotImplemented.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_NotImplemented �쳣ָʾĳ������û��ʵ��
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_NotImplemented extends FLEA_Exception
{
    var $className;
    var $methodName;

    /**
     * ���캯��
     *
     * @param string $method
     * @param string $class
     *
     * @return FLEA_Exception_NotImplemented
     */
    function FLEA_Exception_NotImplemented($method, $class = '') {
        $this->className = $class;
        $this->methodName = $method;
        if ($class) {
            $code = 0x010200a;
            parent::FLEA_Exception(sprintf(_E($code), $class, $method));
        } else {
            $code = 0x010200b;
            parent::FLEA_Exception(sprintf(_E($code), $method));
        }
    }
}
