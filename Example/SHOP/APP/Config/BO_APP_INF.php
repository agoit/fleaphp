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
 * 定义应用程序设置
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BO_APP_INF.php 641 2006-12-19 11:51:53Z dualface $
 */

return array(
    /**
     * 应用程序标题
     */
    'appTitle' => 'FleaPHP Example SHOP',

    /**
     * 指定默认控制器
     */
    'defaultController' => 'BoLogin',

    /**
     * 指定要使用的调度器
     */
    'dispatcher' => 'FLEA_Dispatcher_Auth',

    /**
     * 指示应用程序内部处理数据及页面显示要使用的编码
     */
    'responseCharset' => 'utf-8',

    /**
     * 指示数据库要使用的编码
     */
    'databaseCharset' => 'utf8',

    /**
     * 启用多语言支持
     */
    'multiLangaugeSupport' => true,

    /**
     * 指定语言文件所在目录
     */
    'languageFilesDir' => realpath(dirname(__FILE__) . '/../Languages'),

    /**
     * 指示可用的语言
     */
    'languages' => array(
        'chinese-utf8' => '简体中文',
        'chinese-utf8-tw' => '繁体中文',
    ),

    /**
     * 指示默认语言
     */
    'defaultLanguage' => 'chinese-utf8',

    /**
     * 上传目录和 URL 访问路径
     */
    'uploadDir' => UPLOAD_DIR,
    'uploadRoot' => UPLOAD_ROOT,

    /**
     * 缩略图的大小、可用扩展名
     */
    'thumbWidth' => 166,
    'thumbHeight' => 166,
    'thumbFileExts' => 'gif,png,jpg,jpeg',

    /**
     * 商品大图片的最大文件尺寸和可用扩展名
     */
    'photoMaxFilesize' => 1000 * 1024,
    'photoFileExts' => 'gif,png,jpg,jpeg',

    /**
     * 使用默认的控制器 ACT 文件
     *
     * 这样可以避免为每一个控制器都编写 ACT 文件
     */
    'defaultControllerACTFile' => dirname(__FILE__) . DS . 'DefaultACT.php',

    /**
     * 必须设置该选项为 true，才能启用默认的控制器 ACT 文件
     */
    'autoQueryDefaultACTFile' => true,
);
