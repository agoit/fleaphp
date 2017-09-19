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
 * ���� FLEA_Db_Exception_MissingPrimaryKey �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: MissingPrimaryKey.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_MissingPrimaryKey �쳣ָʾû���ṩ�����ֶ�ֵ
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_MissingPrimaryKey extends FLEA_Exception
{
    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey;

    /**
     * ���캯��
     *
     * @param string $pk
     *
     * @return FLEA_Db_Exception_MissingPrimaryKey
     */
    function FLEA_Db_Exception_MissingPrimaryKey($pk) {
        $this->primaryKey = $pk;
        $code = 0x06ff003;
        parent::FLEA_Exception(sprintf(_E($code), $pk));
    }
}
