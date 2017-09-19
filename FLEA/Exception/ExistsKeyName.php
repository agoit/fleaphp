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
 * ���� FLEA_Exception_ExistsKeyName �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: ExistsKeyName.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_ExistsKeyName �쳣ָʾ��Ҫ�ļ����Ѿ�����
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_ExistsKeyName extends FLEA_Exception
{
    var $keyname;

    /**
     * ���캯��
     *
     * @param string $keyname
     *
     * @return FLEA_Exception_ExistsKeyName
     */
    function FLEA_Exception_ExistsKeyName($keyname) {
        $this->keyname = $keyname;
        parent::FLEA_Exception(sprintf(_E(0x0102004), $keyname));
    }
}
