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
 * ���� FLEA_Db_Exception_MissingDSN �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: MissingDSN.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_MissingDSN �쳣ָʾû���ṩ�������ݿ���Ҫ�� dbDSN Ӧ�ó�������
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_MissingDSN extends FLEA_Exception
{
    /**
     * ���캯��
     *
     * @return FLEA_Db_Exception_MissingDSN
     */
    function FLEA_Db_Exception_MissingDSN() {
        $code = 0x06ff002;
        parent::FLEA_Exception(_E($code), $code);
    }
}
