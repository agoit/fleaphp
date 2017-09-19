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
 * ���� FLEA_Db_Exception_MissingLinkOption �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: MissingLinkOption.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_MissingLinkOption �쳣ָʾ���� TableLink ����ʱû���ṩ�����ѡ��
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_MissingLinkOption extends FLEA_Exception
{
    /**
     * ȱ�ٵ�ѡ����
     *
     * @var string
     */
    var $option;

    /**
     * ���캯��
     *
     * @param string $option
     *
     * @return FLEA_Db_Exception_MissingLinkOption
     */
    function FLEA_Db_Exception_MissingLinkOption($option) {
        $this->option = $option;
        $code = 0x0202002;
        parent::FLEA_Exception(sprintf(_E($code), $option));
    }
}
