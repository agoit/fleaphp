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
 * 定义 ___magic_quotes_filter 函数
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: MagicQuotes.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * 根据 magic_quotes 设置将转义字符去掉
 *
 * 该函数由框架自动调用，应用程序不需要调用该函数。
 */
function ___magic_quotes_filter() {
    if (!get_magic_quotes_gpc()) { return; }
    $in = array(& $_GET, & $_POST, & $_COOKIE, & $_REQUEST);
    while (list($k,$v) = each($in)) {
    	foreach ($v as $key => $val) {
    		if (!is_array($val)) {
    			$in[$k][$key] = stripslashes($val);
    			continue;
    		}
    		$in[] =& $in[$k][$key];
    	}
    }
    unset($in);
}

/**
 * 调用过滤器
 */
if (defined('FLEA_VERSION')) {
    log_message('Execute filter MagicQuotes', 'debug');
    ___magic_quotes_filter();
}
