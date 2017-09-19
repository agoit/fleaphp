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
 * 定义用于 PHP5 的 FLEA_Exception 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package PHP5
 * @version $Id: ExceptionPHP5.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception 类封装了一个异常
 *
 * 在 PHP5 中，FLEA_Exception 继承自 PHP 内置的 Exception 类。
 * 在 PHP4 中，则模拟了异常机制。
 *
 * @package PHP5
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception extends Exception
{
    /**
     * 构造函数
     *
     * @param string $message
     * @param int $code
     *
     * @return FLEA_Exception
     */
    function FLEA_Exception($message = '', $code = 0) {
        parent::__construct($message, $code);
    }
}
