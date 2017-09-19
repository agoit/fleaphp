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
 * ���� FLEA_Exception_FileOperation �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: FileOperation.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_FileOperation �쳣ָʾ�ļ�ϵͳ����ʧ��
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_FileOperation extends FLEA_Exception
{
    /**
     * ���ڽ��е��ļ�����
     *
     * @var string
     */
    var $operation;

    /**
     * �����Ĳ���
     *
     * @var array
     */
    var $args;

    /**
     * ���캯��
     *
     * @param string $opeation
     *
     * @return FLEA_Exception_FileOperation
     */
    function FLEA_Exception_FileOperation($opeation) {
        $this->operation = $opeation;
        $args = func_get_args();
        array_shift($args);
        $this->args = $args;
        $func = $opeation . '(' . implode(', ', $args) . ')';
        parent::FLEA_Exception(sprintf(_E(0x0102005), $func));
    }
}
