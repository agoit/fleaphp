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
 * �������� PHP5 �� FLEA_Exception ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package PHP5
 * @version $Id: ExceptionPHP5.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception ���װ��һ���쳣
 *
 * �� PHP5 �У�FLEA_Exception �̳��� PHP ���õ� Exception �ࡣ
 * �� PHP4 �У���ģ�����쳣���ơ�
 *
 * @package PHP5
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception extends Exception
{
    /**
     * ���캯��
     *
     * @param string $message
     * @param int $code
     *
     * @return FLEA_Exception
     */
    function FLEA_Exception($message = '', $code = 0) {
        parent::__construct($message, $code);
    }
}
