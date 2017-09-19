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
 * MVC-Blog 演示了一个使用 FleaPHP 提供的 MVC 模式实现的简单 Blog
 *
 * 该示例程序由网友“小路”贡献，参照 CakePHP 同等示例程序实现。
 * 小路同时在 PHPChina（http://www.phpchina.com/）上发布了该示例程序的 Zend Framework 版本。
 *
 * ZF 版本地址：http://www.phpchina.com/bbs/thread-5820-1-1.html
 *
 * 不过为了充分体现 FleaPHP 的简洁，这个示例程序和 ZF 版的同等程序有一个主要的不同之处：
 *
 * FleaPHP 版的示例程序只有两个控制器，其中默认的控制器不做实际工作，仅仅是重定向浏览器到 Post 控制器；
 * Blog 的列表、查看、删除和添加等操作，都由 Post 控制器完成。
 * 而在 ZF 版的示例程序中，这些操作由多个控制器完成。
 *
 * 通过这个示例程序，开发者可以了解如何使用 FleaPHP 的 MVC 模式。
 * 同时，通过和同等功能的 ZF 版示例程序比较，就能发现 FleaPHP 版的示例程序不但代码更少，
 * 而且结构更清晰易懂。特别是涉及到 Blog 的常见数据库操作只需要一两行代码即可完成。
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 网友“小路”
 * @package Example
 * @subpackage MVC-Blog
 * @version $Id: index.php 684 2007-01-06 20:25:08Z dualface $
 */

/**
 * 尝试载入数据库配置文件，如果失败则显示错误页面
 */
$configFilename = '../_Shared/DSN.php';
if (!is_readable($configFilename)) {
    header('Location: ../../Install/setup-required.php');
}

/**
 * 首先引入fleaphp的库文件,并会做一些基本的处理.
 * 例如载入StdLibs.php,以便提供常用的fleaphp函数.
 */
require('../../FLEA/FLEA.php');

/**
 * 指定实际代码的路径,Fleaphp之所以能自动找到controller目录,model目录下的类,全靠这里指定路径
 */
import(dirname(__FILE__) . '/APP');

/**
 * 找不到的类自动加载,例如:FLEA_Db_TableDataGateway类就是.
 * 注意,此方法不可用于php4,只能用于PHP5
 */
function __autoload($className) {
    load_class($className);
}

/**
 * 指定数据库连接设置，TableDataGateway 会自动取出 dbDSN 设置来连接数据库。
 * register_app_inf() 会用开发者指定的应用程序设置覆盖 FleaPHP 提供的默认设置。
 * 开发者可以使用 get_app_inf() 取出任意应用程序设置。
 */
register_app_inf($configFilename);

/**
 * 设置 url 模式为 URL_PATHINFO
 *
 * 默认 url 模式的显示效果为 http://localhost/index.php?controller=Post&action=Index
 * URL_PATHINFO 的显示效果为 http://localhost/index.php/Post/Index/
 */
set_app_inf('urlMode', URL_PATHINFO);

/**
 * run()只做两件事情:
 *
 * 一.会准备运行环境.
 * 二.根据url地址实例化指定的controller类,调用指定的action.
 */
run();
