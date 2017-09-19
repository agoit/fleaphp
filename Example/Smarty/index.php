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
 * Smarty 演示了如何在 FleaPHP 应用程序中使用 Smarty 模版引擎
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage Smarty
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

define('APP_DIR', dirname(__FILE__));
require('../../FLEA/FLEA.php');

/**
 * 要使用 Smarty，必须做两项准备工作
 *
 * 1、设置应用程序的 view 选项为 FLEA_View_Smarty；
 * 2、设置应用程序的 viewConfig 选项为数组，数组中必须包含
 *    smartyDir 选项，指示 Smarty 模版引擎源代码所在目录。
 *
 * 如果需要在构造 FLEA_View_Smarty 时就初始化 Smarty 模版引擎的设置，
 * 直接放置在 viewConfig 选项数组中即可。
 */
$appInf = array(
    'view' => 'FLEA_View_Smarty',
    'viewConfig' => array(
        'smartyDir'         => APP_DIR . '/Smarty',
        'template_dir'      => APP_DIR,
        'compile_dir'       => APP_DIR . '/templates_c',
        'left_delimiter'    => '{{',
        'right_delimiter'   => '}}',
    ),
);

register_app_inf($appInf);
import(dirname(__FILE__));
run();
