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
 * Shop 演示了一个简单的商品分类管理和商品管理程序
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * 尝试载入数据库配置文件，如果失败则显示错误页面
 */
$configFilename = '../_Shared/DSN.php';
if (!is_readable($configFilename)) {
    header('Location: ../../Install/setup-required.php');
}

// APP_DIR 常量指示模版的保存目录
define('APP_DIR', dirname(__FILE__));
// UPLOAD_DIR 常量用于指示保存上传文件的根目录
define('UPLOAD_DIR', realpath(APP_DIR . '/upload'));
// UPLOAD_ROOT 常量用于指示用什么 URL 路径访问上传目录
define('UPLOAD_ROOT', 'upload');

require('../../FLEA/FLEA.php');
register_app_inf($configFilename);
register_app_inf(APP_DIR . '/APP/Config/BO_APP_INF.php');
import(APP_DIR . '/APP');

run();
