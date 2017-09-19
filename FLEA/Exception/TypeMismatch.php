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
 * ���� FLEA_Exception_TypeMismatch �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: TypeMismatch.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_TypeMismatch �쳣ָʾһ�����Ͳ�ƥ�����
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_TypeMismatch extends FLEA_Exception
{
    var $arg;
    var $expected;
    var $actual;

    /**
     * ���캯��
     *
     * @param string $arg
     * @param string $expected
     * @param string $actual
     *
     * @return FLEA_Exception_TypeMismatch
     */
    function FLEA_Exception_TypeMismatch($arg, $expected, $actual) {
        $this->arg = $arg;
        $this->expected = $expected;
        $this->actual = $actual;
        $code = 0x010200c;
        $msg = sprintf(_E($code), $arg, $expected, $actual);
        parent::FLEA_Exception($msg, $code);
    }
}
