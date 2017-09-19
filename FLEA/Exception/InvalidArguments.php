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
 * ���� FLEA_Exception_InvalidArguments �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidArguments.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_InvalidArguments �쳣ָʾһ����������
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_InvalidArguments extends FLEA_Exception
{
    var $arg;
    var $value;

    /**
     * ���캯��
     *
     * @param string $arg
     * @param mixed $value
     *
     * @return FLEA_Exception_InvalidArguments
     */
    function FLEA_Exception_InvalidArguments($arg, $value = null) {
        $this->arg = $arg;
        $this->value = $value;
        parent::FLEA_Exception(sprintf(_E(0x0102006), $arg));
    }
}
