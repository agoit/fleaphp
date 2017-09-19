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
 * ���� FLEA_Db_Exception_InvalidLinkType �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidLinkType.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_InvalidLinkType �쳣ָʾ��Ч�����ݱ��������
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_InvalidLinkType extends FLEA_Exception
{
    var $type;

    /**
     * ���캯��
     *
     * @param $type
     *
     * @return FLEA_Db_Exception_InvalidDSN
     */
    function FLEA_Db_Exception_InvalidLinkType($type) {
        $this->type = $type;
        $code = 0x0202001;
        parent::FLEA_Exception(sprintf(_E($code), $type), $code);
    }
}
