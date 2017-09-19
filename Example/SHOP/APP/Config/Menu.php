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
 * 定义后台管理界面左侧的菜单
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: Menu.php 682 2007-01-05 16:25:15Z dualface $
 */

$catalog = array();

$menu = array();
$menu[] = array(_T('ui_w_menu_create_product'), 'BoProducts', 'create');
$menu[] = array(_T('ui_w_menu_list_product'), 'BoProducts');
$menu[] = array('<span style="color: red;">' . _T('ui_w_menu_list_classes') . '</span>', 'BoProductClasses');
$catalog[] = array(_T('ui_w_catalog_products'), $menu);

$menu = array();
$menu[] = array(_T('ui_u_change_password_menu'), 'BoPreference', 'changePassword');
$catalog[] = array(_T('ui_u_preference_catalog'), $menu);

return $catalog;
