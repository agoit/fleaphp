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
 * ���� Exception_ImageFailed ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ImageFailed.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Exception_ImageFailed ָʾͼ�����ʧ��
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Exception_ImageFailed extends FLEA_Exception
{
    var $operation;

    function Exception_ImageFailed($operation) {
        $this->operation = $operation;
        parent::FLEA_Exception(sprintf(_T('ex_image_failed'), $operation));
    }
}
