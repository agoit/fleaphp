<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 FleaPHP 项目的一部分
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 Controller_BoPreference 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoPreference.php 682 2007-01-05 16:25:15Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * 实现个人首选项的设置
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Controller_BoPreference extends Controller_BoBase
{
    /**
     * 显示修改页面
     */
    function actionChangePassword() {
        $rbac =& get_singleton('FLEA_Com_RBAC');
        /* @var $rbac FLEA_Com_RBAC */
        $user = $rbac->getUser();
        include(APP_DIR . '/BoPreferenceChangePassword.php');
    }

    /**
     * 更新密码
     */
    function actionUpdatePassword() {
        $sysusersTDG =& get_singleton('Model_SysUsers');
        /* @var $sysusersTDG Model_SysUsers */
        $rbac =& get_singleton('FLEA_Com_RBAC');
        /* @var $rbac FLEA_Com_RBAC */
        $user = $rbac->getUser();

        // 检查现在输入的用户名是否正确
        $username = $user['USERNAME'];
        if (!$sysusersTDG->validateUser($username, $_POST['old_password'])) {
            js_alert(_T('ui_u_enter_current_password_tip'), '',
                    $this->_url('changePassword'));
        }

        // 检查两次输入的新密码是否一致
        if ($_POST['new_password'] != $_POST['new_password2']) {
            js_alert(_T('ui_u_enter_new_password_not_match'), '',
                    $this->_url('changePassword'));
        }

        if ($_POST['new_password'] == '') {
            js_alert(_T('ui_u_enter_new_password_tip'), '',
                    $this->_url('changePassword'));
        }

        // 更新密码
        $sysusersTDG->changePassword($username,
                $_POST['old_password'], $_POST['new_password']);

        js_alert(_T('ui_u_change_password_successed'), '',
                url('BoDashboard', 'welcome'));
    }
}
