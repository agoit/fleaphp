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
 * ���� Conroller_BoLogin ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoLogin.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Controller_Action');
// }}}

/**
 * Controller_BoLogin ʵ�����û���¼��ע��
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_BoLogin extends FLEA_Controller_Action
{
    /**
     * ���캯��
     *
     * @return Controller_BoLogin
     */
    function Controller_BoLogin() {
        load_language('ui');
    }

    /**
     * ��ʾ��¼����
     */
    function actionIndex() {
        require(APP_DIR . '/BoLoginIndex.php');
    }

    /**
     * ע��
     */
    function actionLogout() {
        session_destroy();
        $msg = _T('ui_l_logout');
        include(APP_DIR . '/BoLoginIndex.php');
    }

    /**
     * ��¼
     */
    function actionLogin() {
        $imgcode =& get_singleton('FLEA_Helper_ImgCode');
        /* @var $imgcode FLEA_Helper_ImgCode */
        do {
            if (!$imgcode->check($_POST['imgcode'])) {
                $msg = _T('ui_l_invalid_imgcode');
                break;
            }
            $imgcode->clear();

            /**
             * ��֤�û����������Ƿ���ȷ
             */
            $sysusers =& get_singleton('Model_SysUsers');
            /* @var $sysusers Model_SysUsers */
            $user = $sysusers->findByUsername($_POST['username']);
            if (!$user) {
                $msg = _T('ui_l_invalid_username');
                break;
            }

            if (!$sysusers->checkPassword($_POST['password'],
                $user[$sysusers->passwordField]))
            {
                $msg = _T('ui_l_invalid_password');
                break;
            }

            /**
             * ��¼�ɹ���ͨ�� RBAC �����û���Ϣ�ͽ�ɫ
             */
            $data = array();
            $data['USERNAME'] = $user[$sysusers->usernameField];
            $data['ID'] = $user[$sysusers->primaryKey];

            $rbac =& get_singleton('FLEA_Com_RBAC');
            /* @var $rbac FLEA_Com_RBAC */
            $rbac->setUser($data, $sysusers->fetchRoles($user));

            // �����û�ѡ�������
            $_SESSION['LANG'] = $_POST['language'];

            // �ض���
            redirect(url('BoDashboard'));
        }
        while (false);

        // ��¼���������ٴ���ʾ��¼����
        include(APP_DIR . '/BoLoginIndex.php');
    }

    /**
     * ��ʾ��֤��
     */
    function actionImgCode() {
        $imgcode =& get_singleton('FLEA_Helper_ImgCode');
        /* @var $imgcode FLEA_Helper_ImgCode */
        $imgcode->image();
    }
}
