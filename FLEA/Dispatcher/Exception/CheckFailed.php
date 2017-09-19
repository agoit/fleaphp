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
 * ���� FLEA_Dispatcher_Exception_CheckFailed �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: CheckFailed.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Dispatcher_Exception_CheckFailed �쳣ָʾ�û���ͼ���ʵĿ�����������������û�����
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Dispatcher_Exception_CheckFailed extends FLEA_Exception
{
    var $controllerName;
    var $actionName;

    /**
     * ���캯��
     *
     * @param string $controllerName
     * @param string $actionName
     *
     * @return FLEA_Dispatcher_Exception_CheckFailed
     */
    function FLEA_Dispatcher_Exception_CheckFailed($controllerName, $actionName) {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $code = 0x0701004;
        $msg = sprintf(_E($code), $controllerName, $actionName);
        parent::FLEA_Exception($msg, $code);
    }
}
