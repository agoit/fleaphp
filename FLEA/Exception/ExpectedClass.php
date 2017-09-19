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
 * ���� FLEA_Exception_ExpectedClass �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: ExpectedClass.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_ExpectedClass �쳣ָʾ��Ҫ����û���ҵ�
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_ExpectedClass extends FLEA_Exception
{
    var $className;
    var $classFile;

    /**
     * ���캯��
     *
     * @param string $className
     * @param string $file
     *
     * @return FLEA_Exception_ExpectedClass
     */
    function FLEA_Exception_ExpectedClass($className, $file = null) {
        $this->className = $className;
        $this->classFile = $file;
        if ($file) {
            $code = 0x0102002;
            $msg = sprintf(_E($code), $file, $className);
        } else {
            $code = 0x0102003;
            $msg = sprintf(_E($code), $className);
        }
        parent::FLEA_Exception($msg, $code);
    }
}
