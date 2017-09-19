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
 * ���� FLEA_Db_Exception_PrimaryKeyExists �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: PrimaryKeyExists.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_PrimaryKeyExists �쳣ָʾ�ڲ���Ҫ����ֵ��ʱ��ȴ�ṩ������ֵ
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_PrimaryKeyExists extends FLEA_Exception
{
    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey;

    /**
     * �����ֶ�ֵ
     *
     * @var mixed
     */
    var $pkValue;

    /**
     * ���캯��
     *
     * @param string $pk
     * @param mixed $pkValue
     *
     * @return FLEA_Db_Exception_PrimaryKeyExists
     */
    function FLEA_Db_Exception_PrimaryKeyExists($pk, $pkValue = null) {
        $this->primaryKey = $pk;
        $this->pkValue = $pkValue;
        $code = 0x06ff004;
        $msg = sprintf(_E($code), $pk, $pkValue);
        parent::FLEA_Exception($msg, $code);
    }
}
