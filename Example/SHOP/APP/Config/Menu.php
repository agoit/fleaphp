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
 * �����̨����������Ĳ˵�
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
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
