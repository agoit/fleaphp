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
 * 定义 FLEA_Exception_InvalidArguments 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidArguments.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_InvalidArguments 异常指示一个参数错误
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_InvalidArguments extends FLEA_Exception
{
    var $arg;
    var $value;

    /**
     * 构造函数
     *
     * @param string $arg
     * @param mixed $value
     *
     * @return FLEA_Exception_InvalidArguments
     */
    function FLEA_Exception_InvalidArguments($arg, $value = null) {
        $this->arg = $arg;
        $this->value = $value;
        parent::FLEA_Exception(sprintf(_E(0x0102006), $arg));
    }
}
