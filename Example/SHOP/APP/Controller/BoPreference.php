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
 * ���� Controller_BoPreference ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoPreference.php 682 2007-01-05 16:25:15Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * ʵ�ָ�����ѡ�������
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_BoPreference extends Controller_BoBase
{
    /**
     * ��ʾ�޸�ҳ��
     */
    function actionChangePassword() {
        $rbac =& get_singleton('FLEA_Com_RBAC');
        /* @var $rbac FLEA_Com_RBAC */
        $user = $rbac->getUser();
        include(APP_DIR . '/BoPreferenceChangePassword.php');
    }

    /**
     * ��������
     */
    function actionUpdatePassword() {
        $sysusersTDG =& get_singleton('Model_SysUsers');
        /* @var $sysusersTDG Model_SysUsers */
        $rbac =& get_singleton('FLEA_Com_RBAC');
        /* @var $rbac FLEA_Com_RBAC */
        $user = $rbac->getUser();

        // �������������û����Ƿ���ȷ
        $username = $user['USERNAME'];
        if (!$sysusersTDG->validateUser($username, $_POST['old_password'])) {
            js_alert(_T('ui_u_enter_current_password_tip'), '',
                    $this->_url('changePassword'));
        }

        // �������������������Ƿ�һ��
        if ($_POST['new_password'] != $_POST['new_password2']) {
            js_alert(_T('ui_u_enter_new_password_not_match'), '',
                    $this->_url('changePassword'));
        }

        if ($_POST['new_password'] == '') {
            js_alert(_T('ui_u_enter_new_password_tip'), '',
                    $this->_url('changePassword'));
        }

        // ��������
        $sysusersTDG->changePassword($username,
                $_POST['old_password'], $_POST['new_password']);

        js_alert(_T('ui_u_change_password_successed'), '',
                url('BoDashboard', 'welcome'));
    }
}
