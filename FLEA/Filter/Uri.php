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
 * 定义 ___uri_filter 函数
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: Uri.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * 根据应用程序设置 'urlMode' 分析 $_GET 参数
 *
 * 该函数由框架自动调用，应用程序不需要调用该函数。
 */
function ___uri_filter() {
    // 处理 PATHINFO
    if (!isset($_SERVER['PATH_INFO'])) { return; }
    $_GET = array();
    $parts = explode('/', substr($_SERVER['PATH_INFO'], 1));
    $_GET[get_app_inf('controllerAccessor')] = isset($parts[0]) ? $parts[0] : '';
    $_GET[get_app_inf('actionAccessor')] = isset($parts[1]) ? $parts[1] : '';

    for ($i = 2; $i < count($parts); $i += 2) {
        if (trim($parts[$i]) && isset($parts[$i + 1])) {
            $_GET[$parts[$i]] = $parts[$i + 1];
        }
    }
    // 将 $_GET 合并到 $_REQUEST，有时需要使用 $_REQUEST 统一处理 url 中的 id=? 这样的参数
    $_REQUEST = array_merge($_REQUEST, $_GET);
}

/**
 * 调用过滤器
 */
if (defined('FLEA_VERSION')) {
    log_message('Execute filter Uri', 'debug');
    ___uri_filter();
}
