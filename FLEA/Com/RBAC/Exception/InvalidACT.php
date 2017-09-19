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
 * ���� FLEA_Com_RBAC_Exception_InvalidACT �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidACT.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Com_RBAC_Exception_InvalidACT �쳣ָʾһ����Ч�� ACT
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_RBAC_Exception_InvalidACT extends FLEA_Exception
{
    /**
     * ��Ч�� ACT ����
     *
     * @var mixed
     */
    var $act;

    /**
     * ���캯��
     *
     * @param mixed $act
     *
     * @return FLEA_Com_RBAC_Exception_InvalidACT
     */
    function FLEA_Com_RBAC_Exception_InvalidACT($act) {
        $this->act = $act;
        $code = 0x0701001;
        parent::FLEA_Exception(_E($code), $code);
    }
}
