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
 * 初始化 FleaPHP 运行环境
 *
 * 对于大部分 FleaPHP 的组件，都要求预先初始化 FleaPHP 环境。
 * 在应用程序中只需要通过 require('FLEA/FLEA.php'); 载入该文件，
 * 即可完成 FleaPHP 运行环境的初始化工作。
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: FLEA.php 686 2007-01-06 20:30:22Z dualface $
 */

// {{{ constants

/**
 * 保存文件载入的时间
 */
global $___fleaphp_loaded_time;
$___fleaphp_loaded_time = microtime();

/**
 * 定义 FleaPHP 版本号常量
 */
define('FLEA_VERSION', '1.0.61.686');

/**
 * 定义指示 PHP4 或 PHP5 的常量
 */
if (substr(PHP_VERSION, 0, 1) == '5') {
    define('PHP5', true);
} else {
    define('PHP4', true);
}

/**
 * 简写的 DIRECTORY_SEPARATOR
 */
define('DS', DIRECTORY_SEPARATOR);

/**#@+
 * 定义可用的 URL 模式
 */
/**
 * 标准 URL 模式
 */
define('URL_STANDARD',  1);

/**
 * PATHINFO 模式
 */
define('URL_PATHINFO',  2);

/**
 * URL 重写模式
 */
define('URL_REWRITE',   3);
/**#@-*/

/**#@+
 * 定义 RBAC 基本角色常量
 */
/**
 * RBAC_EVERYONE 表示任何用户（不管该用户是否具有角色信息）
 */
define('RBAC_EVERYONE',     -1);

/**
 * RBAC_HAS_ROLE 表示具有任何角色的用户
 */
define('RBAC_HAS_ROLE',     -2);

/**
 * RBAC_NO_ROLE 表示不具有任何角色的用户
 */
define('RBAC_NO_ROLE',      -3);

/**
 * RBAC_NULL 表示该设置没有值
 */
define('RBAC_NULL',         null);
/**#@-*/

// }}}

// {{{ init

/**
 * 初始化 FleaPHP 要使用的全局变量
 */
define('G_FLEA_VAR', '__FLEA_CORE__');
$GLOBALS[G_FLEA_VAR] = array(
    'APP_INF'                => array(),
    'OBJECTS'                => array(),
    'CLASS_PATH'             => array(),
    'FLEA_EXCEPTION_STACK'   => array(),
    'FLEA_EXCEPTION_HANDLER' => null,
);

/**
 * 定义 FleaPHP 文件所在位置，以及初始的 CLASS_PATH
 */
define('FLEA_DIR', dirname(__FILE__));
$GLOBALS[G_FLEA_VAR]['CLASS_PATH'] = array(dirname(FLEA_DIR));

/**
 * 消除在 PHP5 中运行时产生的警告信息
 */
if (!defined('E_STRICT')) {
    define('E_STRICT', 2048);
}
error_reporting(error_reporting(0) & ~E_STRICT);

/**
 * 载入默认设置文件
 */
$GLOBALS[G_FLEA_VAR]['APP_INF'] = (array)require(FLEA_DIR . '/Config/Default_APP_INF.php');

/**
 * 载入基本函数库
 */
require(FLEA_DIR . '/StdLibs.php');

/**
 * 载入基本异常定义，并设置异常处理例程
 */
if (defined('PHP5')) {
    require(FLEA_DIR . '/ExceptionPHP5.php');
} else {
    require(FLEA_DIR . '/ExceptionPHP4.php');
}
__SET_EXCEPTION_HANDLER('__FLEA_EXCEPTION_HANDLER');
// }}}

// {{{ prepare runtime
/**
 * 准备运行环境：载入配置文件、运行过滤器、处理 session 等
 *
 * __FLEA_PREPARE() 根据应用程序设置，完成自动载入文件、运行输入过滤器、
 * 打开 session 支持等任务。
 *
 * 如果应用程序使用 run() 函数启动 MVC 模式，那么 __FLEA_PREPARE() 函数
 * 会被自动调用。否则开发者可以选择自己调用 __FLEA_PREPARE() 来准备运行环境。
 */
function __FLEA_PREPARE() {
    static $firstTime = true;

    // 避免重复调用 __FLEA_PREPARE()
    if (!$firstTime) { return; }
    $firstTime = false;

    /**
     * 载入日志服务提供程序
     */
    if (get_app_inf('logProvider') && get_app_inf('logEnabled')) {
        load_class(get_app_inf('logProvider'));
    }
    if (!function_exists('log_message')) {
        // 如果没有指定日志服务提供程序，就定义一个空的 log_message() 函数
        eval('function log_message() {}');
    }

    log_message('__FLEA_PREPARE()', 'debug');

    // 过滤 magic_quotes
    if (get_magic_quotes_gpc()) {
        require(FLEA_DIR . '/Filter/MagicQuotes.php');
    }
    set_magic_quotes_runtime(0);

    // 根据 URL 模式设置，决定是否要载入 URL 分析过滤器
    if (get_app_inf('urlMode') != URL_STANDARD) {
        require(FLEA_DIR . '/Filter/Uri.php');
    }

    // 处理 requestFilters
    foreach ((array)get_app_inf('requestFilters') as $file) {
        load_file($file);
    }

    // 处理 autoLoad
    foreach ((array)get_app_inf('autoLoad') as $file) {
        load_file($file);
    }

    // 载入指定的 session 服务提供程序
    if (get_app_inf('sessionProvider')) {
        load_file(get_app_inf('sessionProvider'));
    }
    // 自动起用 session 会话
    if (get_app_inf('autoSessionStart')) {
        session_start();
    }

    // 定义 I18N 相关的常量
    if (get_app_inf('charsetConstant')) {
        define('RESPONSE_CHARSET', get_app_inf('responseCharset'));
        define('DATABASE_CHARSET', get_app_inf('databaseCharset'));
    }

    // 检查是否启用多语言支持
    if (get_app_inf('multiLangaugeSupport')) {
        load_class(get_app_inf('languageSupportProvider'));
    }
    if (!function_exists('_T')) {
        // 如果没有指定多语言支持，就定义一个空的 _T() 函数
        eval('function _T($key) { return $key; }');
    }
    if (!function_exists('load_language')) {
        eval('function load_language($dictname, $langauge = null) { return false; }');
    }

    // 自动输出内容头信息
    if (get_app_inf('autoResponseHeader')) {
        header('Content-Type: text/html; charset=' . get_app_inf('responseCharset'));
    }
}

// }}}

/**
 * FLEA 应用程序入口
 */
function run() {
    // 准备运行环境
    __FLEA_PREPARE();

    // 载入调度器并转发请求到控制器
    $dispatcher =& get_singleton(get_app_inf('dispatcher'));
    $dispatcher->dispatching($_GET);
}
