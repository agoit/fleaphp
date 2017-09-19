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
 * ���� FLEA_Exception_MissingController �쳣
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: MissingController.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_MissingController ָʾ����Ŀ�����û���ҵ�
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_MissingController extends FLEA_Exception
{
    /**
     * ������������
     *
     * @var string
     */
    var $controller;

    /**
     * Action ��������
     *
     * @var string
     */
    var $action;

    /**
     * ���ò���
     *
     * @var mixed
     */
    var $arguments;

    /**
     * ���캯��
     *
     * @param string $controller
     * @param string $action
     * @param mixed $arguments
     *
     * @return FLEA_Exception_MissingController
     */
    function FLEA_Exception_MissingController($controller, $action, $arguments = null) {
        $this->controller = $controller;
        $this->action = $action;
        $this->arguments = $arguments;
        $code = 0x0103002;
        parent::FLEA_Exception(sprintf(_E($code), $controller));
    }
}
