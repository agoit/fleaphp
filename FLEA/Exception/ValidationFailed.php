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
 * ���� FLEA_Exception_ValidationFailed �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: ValidationFailed.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_ValidationFailed �쳣ָʾ������֤ʧ��
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_ValidationFailed extends FLEA_Exception
{
    /**
     * ����֤������
     *
     * @var mixed
     */
    var $data;

    /**
     * ��֤���
     *
     * @var array
     */
    var $result;

    /**
     * ���캯��
     *
     * @param array $result
     * @param mixed $data
     *
     * @return FLEA_Exception_ValidationFailed
     */
    function FLEA_Exception_ValidationFailed($result, $data = null) {
        $this->result = $result;
        $this->data = $data;
        $code = 0x0407001;
        $msg = sprintf(_E($code), implode(', ', array_keys((array)$result)));
        parent::FLEA_Exception($msg, $code);
    }
}
