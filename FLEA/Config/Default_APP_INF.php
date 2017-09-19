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
 * FleaPHP 应用程序的默认设置
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Config
 * @version $Id: Default_APP_INF.php 640 2006-12-19 11:51:09Z dualface $
 */

return array(
    // {{{ 核心配置

    /**
     * 应用程序的默认名字空间
     */
    'namespace'                 => '',

    /**
     * 指示控制器的 url 参数名和默认控制器名
     *
     * 控制器名字只能是a-z字母和0-9数字，以及“_”下划线。
     */
    'controllerAccessor'        => 'controller',
    'defaultController'         => 'Default',

    /**
     * 指示 动作方法的 url 参数名和默认 动作方法名
     */
    'actionAccessor'            => 'action',
    'defaultAction'             => 'index',

    /**
     * url 参数的传递模式，可以是标准、PATHINFO、URL 重写等模式
     */
    'urlMode'                   => URL_STANDARD,

    /**
     * 是否将 url 参数中包含的控制器名字和动作名字强制转为小写
     */
    'urlLowerChar'              => false,

    /**
     * 控制器类名称前缀
     */
    'controllerClassPrefix'     => 'Controller_',

    /**
     * 控制器中，动作方法名的前缀和后缀
     * 使用前缀和后缀可以进一步保护控制器中的私有方法
     */
    'actionMethodPrefix'        => 'action',
    'actionMethodSuffix'        => '',

    /**
     * 应用程序要使用的 url 调度器
     */
    'dispatcher'                => 'FLEA_Dispatcher_Simple',

    /**
     * 调度器调度失败（例如控制器或控制器方法不存在）后，要调用的处理程序
     */
    'dispatcherFailedCallback'  => null,

    /**
     * FleaPHP 内部及 cache 系列函数使用的缓存目录
     */
    'internalCacheDir'          => FLEA_DIR . DS . '_Cache',

    /**
     * 指示要自动载入的文件
     */
    'autoLoad'                  => array(
        'FLEA_Helper_Array.php',
        'FLEA_Helper_Html.php',
        'FLEA_Controller_Action.php',
    ),

    /**
     * 指示是否载入 session 提供程序
     */
    'sessionProvider'           => null,

    /**
     * 指示是否自动起用 session 支持
     */
    'autoSessionStart'          => true,

    /**
     * 指示使用哪些过滤器对 HTTP 请求进行过滤
     */
    'requestFilters'            => array(),

    // }}}

    // {{{ 数据库相关

    /**
     * 数据库配置，可以是数组，也可以是 DSN 字符串
     */
    'dbDSN'                     => null,

    /**
     * 指示构造 TableDataGateway 对象时，是否自动连接到数据库
     */
    'dbTDGAutoInit'             => true,

    /**
     * 数据表的全局前缀
     */
    'dbTablePrefix'             => '',

    /**
     * TableDataGateway 要使用的数据验证服务对象
     */
    'dbValidationProvider'      => 'FLEA_Helper_Validation',

    // }}}

    // {{{ View 相关

    /**
     * 要使用的模板引擎，'PHP' 表示使用 PHP 语言本身作模板引擎
     */
    'view'                      => 'PHP',

    /**
     * 模板引擎要使用的配置信息
     */
    'viewConfig'                => null,

    // }}}

    // {{{ I18N

    /**
     * 指示 FleaPHP 应用程序内部处理数据和输出内容要使用的编码
     */
    'responseCharset'           => 'gb2312',

    /**
     * 当 FleaPHP 连接数据库时，用什么编码传递数据
     */
    'databaseCharset'           => 'gb2312',

    /**
     * 是否自动输出 Content-Type: text/html; charset=responseCharset
     */
    'autoResponseHeader'        => true,

    /**
     * 是否自动定义 RESPONSE_CHARSET、DATABASE_CHARSET 等常量
     */
    'charsetConstant'           => true,

    /**
     * 指示是否启用多语言支持
     */
    'multiLangaugeSupport'      => false,

    /**
     * 指定提供多语言支持的提供程序
     */
    'languageSupportProvider'   => 'FLEA_Com_Language',

    /**
     * 指示语言文件的保存位置
     */
    'languageFilesDir'          => null,

    /**
     * 指示默认语言
     */
    'defaultLanguage'           => 'chinese-gb2312',

    /**
     * 自动载入的语言文件
     */
    'autoLoadLanguage'          => null,

    // }}}

    // {{{ FLEA_Dispatcher_Auth 和 RBAC 组件

    /**
     * 调度器要使用的验证服务提供程序
     */
    'dispatcherAuthProvider'    => 'FLEA_Com_RBAC',

    /**
     * 指示 RBAC 组件要使用的默认 ACT 文件
     */
    'defaultControllerACTFile'  => '',

    /**
     * 指示 RBAC 组件是否在没有找到控制器的 ACT 文件时，
     * 是否从默认 ACT 文件中查询控制器的 ACT
     */
    'autoQueryDefaultACTFile'   => false,

    /**
     * 当控制器没有提供 ACT 文件时，显示警告信息
     */
    'controllerACTLoadWarning'  => true,

    /**
     * 指示当没有为控制器提供 ACT 时，要使用的默认 ACT
     */
    'defaultControllerACT'      => null,

    /**
     * 用户没有权限访问控制器或控制器方法时，要调用的处理程序
     */
    'dispatcherAuthFailedCallback' => null,

    /**
     * 指示 RBAC 组件用什么键名在 session 中保存用户数据
     * 如果在一个域名下同时运行多个应用程序，请务必为每一个应用程序使用自己独一无二的键名
     */
    'RBACSessionKey'            => 'RBAC_USERDATA',

    // }}}

    // {{{ 日志和错误处理
    /**
     * 指示是否启用日志服务
     */
    'logEnabled'                => false,

    /**
     * 指示日志服务的程序
     */
    'logProvider'               => 'FLEA_Com_Log',

    /**
     * 指示用什么目录保存日志文件
     */
    'logFileDir'                => null,

    /**
     * 指示用什么文件名保存日志
     */
    'logFilename'               => 'access.log',

    /**
     * 指示当日志文件超过多少 KB 时，自动创建新的日志文件，单位是 KB，不能小于 512KB
     */
    'logFileMaxSize'            => 4096,

    /**
     * 指示哪些级别的错误要保存到日志中
     */
    'logErrorLevel'             => 'warning, error, exception',

    /**
     * 指示是否显示错误信息
     */
    'displayErrors'             => true,

    /**
     * 指示是否显示友好的错误信息
     */
    'friendlyErrorsMessage'     => true,

    // }}}
);
