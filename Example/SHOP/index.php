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
 * Shop ��ʾ��һ���򵥵���Ʒ����������Ʒ�������
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * �����������ݿ������ļ������ʧ������ʾ����ҳ��
 */
$configFilename = '../_Shared/DSN.php';
if (!is_readable($configFilename)) {
    header('Location: ../../Install/setup-required.php');
}

// APP_DIR ����ָʾģ��ı���Ŀ¼
define('APP_DIR', dirname(__FILE__));
// UPLOAD_DIR ��������ָʾ�����ϴ��ļ��ĸ�Ŀ¼
define('UPLOAD_DIR', realpath(APP_DIR . '/upload'));
// UPLOAD_ROOT ��������ָʾ��ʲô URL ·�������ϴ�Ŀ¼
define('UPLOAD_ROOT', 'upload');

require('../../FLEA/FLEA.php');
register_app_inf($configFilename);
register_app_inf(APP_DIR . '/APP/Config/BO_APP_INF.php');
import(APP_DIR . '/APP');

run();
