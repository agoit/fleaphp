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
 * MVC-Basic 演示了 FleaPHP 的 MVC 模式
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage MVC-Basic
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * 所有 FleaPHP 应用程序都必须载入 FLEA.php 文件
 *
 * 载入 FLEA.php 文件时，FleaPHP 框架的核心会自动初始化。初始化部分包括：
 *     公共函数库（FLEA/StdLibs.php）
 *     异常（FLEA/ExceptionPHP4/5.php）
 */
require('../../FLEA/FLEA.php');

/**
 * import 是一个非常重要的函数
 *
 * 该函数添加一个指定路径到 FleaPHP 内部的文件搜索路径列表中。
 * FleaPHP 的 load_class()、get_file_path() 函数将通过这个搜索路径列表
 * 查找符合 FleaPHP 编码指南命名规范的类定义文件。
 */
import(dirname(__FILE__));

/**
 * run() 函数执行应用程序
 *
 * 对于使用 MVC 模式的 FleaPHP 应用程序，run() 函数是必须调用的。
 *
 * run() 函数执行时，会构造 $dispatcher（默认为 FLEA_Dispatcher_Simple 类）对象。
 * 然后调用 $dispatcher 对象的 dispatching() 方法。
 *
 * dispatching() 方法根据 URL 参数中提供的控制器名称和 Action 名称确定要调用的
 * 控制器及控制器方法。因此 run() 函数和 $dispatcher 对象实际上充当了一个网站的
 * 入口调度员。
 *
 * 由于这个示例程序采用了 FleaPHP 的默认设置，因此在没有提供任何 URL 参数的情况下。
 * 会调用名为 Controller_Default 的控制器，及其 index() 控制器方法。
 *
 * 默认控制器及默认控制器方法的名字均定义在 FleaPHP 的应用程序设置文件中。
 */
run();
