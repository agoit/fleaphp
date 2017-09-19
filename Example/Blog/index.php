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
 * Blog 演示了如何创建一个最简单的 Blog 程序
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * 尝试载入数据库配置文件，如果失败则显示错误页面
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
