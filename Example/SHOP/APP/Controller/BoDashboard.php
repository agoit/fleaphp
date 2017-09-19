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
 * ���� Controller_BoDashboard ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoDashboard.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * ʵ�ֺ�̨�������ʾ
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_BoDashboard extends Controller_BoBase
{
    /**
     * ��ʾ frames ҳ��
     */
    function actionIndex() {
        include(APP_DIR . '/BoDashboardIndex.php');
    }

    /**
     * ��ʾ����������
     */
    function actionTopNav() {
        $rbac =& get_singleton('FLEA_Com_RBAC');
        /* @var $rbac FLEA_Com_RBAC */
        $user = $rbac->getUser();
        include(APP_DIR . '/BoDashboardTopnav.php');
    }

    /**
     * ��ʾ���˵�
     */
    function actionSidebar() {
        // ���ȶ���˵�
        $catalog = load_file('Config_Menu.php');

        // ���� FLEA_Dispatcher_Auth ���û���ɫ�Ϳ����� ACT ������֤
        $dispatcher =& $this->_getDispatcher();

        include(APP_DIR . '/BoDashboardSidebar.php');
    }

    /**
     * ��ʾ��ӭ��Ϣ
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
     * ��ʾϵͳ��Ϣ
     */
    function actionPhpInfo() {
        phpinfo();
    }

    /**
     * ���õ�ǰ��������
     */
    function actionChangeLang() {
        $_SESSION['LANG'] = $_GET['lang'];
        redirect($this->_url());
    }
}
