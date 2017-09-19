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
 * 定义 FLEA_Exception_TypeMismatch 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: TypeMismatch.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_TypeMismatch 异常指示一个类型不匹配错误
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_TypeMismatch extends FLEA_Exception
{
    var $arg;
    var $expected;
    var $actual;

    /**
     * 构造函数
     *
     * @param string $arg
     * @param string $expected
     * @param string $actual
     *
     * @return FLEA_Exception_TypeMismatch
     */
    function FLEA_Exception_TypeMismatch($arg, $expected, $actual) {
        $this->arg = $arg;
        $this->expected = $expected;
        $this->actual = $actual;
        $code = 0x010200c;
        $msg = sprintf(_E($code), $arg, $expected, $actual);
        parent::FLEA_Exception($msg, $code);
    }
}
