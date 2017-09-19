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
 * ���� FLEA_Exception_ExpectedFile �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: ExpectedFile.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_ExpectedFile �쳣ָʾ��Ҫ���ļ�û���ҵ�
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_ExpectedFile extends FLEA_Exception
{
    var $filename;

    /**
     * ���캯��
     *
     * @param string $filename
     *
     * @return FLEA_Exception_ExpectedFile
     */
    function FLEA_Exception_ExpectedFile($filename) {
        $this->filename = $filename;
        $code = 0x0102001;
        $msg = sprintf(_E($code), $filename);
        parent::FLEA_Exception($msg, $code);
    }
}
