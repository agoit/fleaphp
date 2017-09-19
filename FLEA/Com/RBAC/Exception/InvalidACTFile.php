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
 * ���� FLEA_Com_RBAC_Exception_InvalidACTFile �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidACTFile.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Com_RBAC_Exception_InvalidACTFile �쳣ָʾ�������� ACT �ļ���Ч
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_RBAC_Exception_InvalidACTFile extends FLEA_Exception
{
    /**
     * ACT �ļ���
     *
     * @var string
     */
    var $actFilename;

    /**
     * ����������
     *
     * @var string
     */
    var $controllerName;

    /**
     * ��Ч�� ACT ����
     *
     * @var mixed
     */
    var $act;

    /**
     * ���캯��
     *
     * @param string $actFilename
     * @param string $controllerName
     * @param mixed $act
     *
     * @return FLEA_Com_RBAC_Exception_InvalidACTFile
     */
    function FLEA_Com_RBAC_Exception_InvalidACTFile($actFilename,
        $act, $controllerName = null)
    {
        $this->actFilename = $actFilename;
        $this->act = $act;
        $this->controllerName = $controllerName;

        if ($controllerName) {
            $code = 0x0701002;
            $msg = sprintf(_E($code), $actFilename, $controllerName);
        } else {
            $code = 0x0701003;
            $msg = sprintf(_E($code), $actFilename);
        }
        parent::FLEA_Exception($msg, $code);
    }
}
