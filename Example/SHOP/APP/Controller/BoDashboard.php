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
 * 定义 Controller_BoDashboard 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoDashboard.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * 实现后台界面的显示
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Controller_BoDashboard extends Controller_BoBase
{
    /**
     * 显示 frames 页面
     */
    function actionIndex() {
        include(APP_DIR . '/BoDashboardIndex.php');
    }

    /**
     * 显示顶部导航栏
     */
    function actionTopNav() {
        $rbac =& get_singleton('FLEA_Com_RBAC');
        /* @var $rbac FLEA_Com_RBAC */
        $user = $rbac->getUser();
        include(APP_DIR . '/BoDashboardTopnav.php');
    }

    /**
     * 显示左侧菜单
     */
    function actionSidebar() {
        // 首先定义菜单
        $catalog = load_file('Config_Menu.php');

        // 借助 FLEA_Dispatcher_Auth 对用户角色和控制器 ACT 进行验证
        $dispatcher =& $this->_getDispatcher();

        include(APP_DIR . '/BoDashboardSidebar.php');
    }

    /**
     * 显示欢迎信息
     */
    function actionWelcome() {
        $dispatcher =& get_singleton(get_app_inf('dispatcher'));
        /* @var $dispatcher FLEA_Dispatcher_Auth */
        if ($dispatcher->check('BoDashboard', 'phpinfo') &&
            function_exists('phpinfo'))
        {
            $enablePhpinfo = true;
        } else {
            $enablePhpinfo = false;
        }
        include(APP_DIR . '/BoDashboardWelcome.php');
    }

    /**
     * 显示系统信息
     */
    function actionPhpInfo() {
        phpinfo();
    }

    /**
     * 设置当前界面语言
     */
    function actionChangeLang() {
        $_SESSION['LANG'] = $_GET['lang'];
        redirect($this->_url());
    }
}
