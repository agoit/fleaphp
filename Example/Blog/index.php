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
 * Blog ��ʾ����δ���һ����򵥵� Blog ����
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * �����������ݿ������ļ������ʧ������ʾ����ҳ��
 */
$configFilename = '../_Shared/DSN.php';
if (!is_readable($configFilename)) {
    header('Location: ../../Install/setup-required.php');
}

define('APP_DIR', dirname(__FILE__));
require('../../FLEA/FLEA.php');
register_app_inf($configFilename);
import(dirname(__FILE__));
run();
