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
 * ���� FLEA_View_Exception_NotConfigurationSmartTemplate ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: NotConfigurationSmartTemplate.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_View_Exception_NotConfigurationSmartTemplateSmarty ��ʾ������
 * û��Ϊ FLEA_View_SmartTemplate �ṩ��ʼ�� SmartTemplate ģ��������Ҫ������
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_View_Exception_NotConfigurationSmartTemplate extends FLEA_Exception
{
    function FLEA_View_Exception_NotConfigurationSmartTemplate() {
        $code = 0x0903001;
        parent::FLEA_Exception(_E($code), $code);
    }
}
