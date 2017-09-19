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
 * ���� FLEA_Db_Exception_InvalidDSN �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidDSN.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_InvalidDSN �쳣ָʾû���ṩ��Ч�� DSN ����
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_InvalidDSN extends FLEA_Exception
{
    var $dsn;

    /**
     * ���캯��
     *
     * @param $dsn
     *
     * @return FLEA_Db_Exception_InvalidDSN
     */
    function FLEA_Db_Exception_InvalidDSN($dsn) {
        $this->dsn = $dsn;
        $code = 0x06ff001;
        parent::FLEA_Exception(_E($code), $code);
    }
}
