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
 * ���� FLEA_View_Exception_InitSmartTemplateFailed ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: InitSmartTemplateFailed.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_View_Exception_InitSmartTemplateFailed ָʾ FLEA_View_SmartTemplate �޷���ʼ�� SmartTemplate ģ������
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_View_Exception_InitSmartTemplateFailed extends FLEA_Exception
{
    function FLEA_View_Exception_InitSmartTemplateFailed($filename) {
        $code = 0x0903002;
        parent::FLEA_Exception(sprintf(_E($code), $filename), $code);
    }
}
