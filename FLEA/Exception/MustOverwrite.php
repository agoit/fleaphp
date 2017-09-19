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
 * ���� FLEA_Exception_MustOverwrite �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: MustOverwrite.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_MustOverwrite �쳣ָʾĳ����������������������д
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_MustOverwrite extends FLEA_Exception
{
    var $prototypeMethod;

    /**
     * ���캯��
     *
     * @param string $prototypeMethod
     *
     * @return FLEA_Exception_MustOverwrite
     */
    function FLEA_Exception_MustOverwrite($prototypeMethod) {
        $this->prototypeMethod = $prototypeMethod;
        $code = 0x0102008;
        $msg = sprintf(_E($code), $prototypeMethod);
        parent::FLEA_Exception($msg, $code);
    }
}
