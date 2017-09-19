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
 * 定义 FLEA_Exception_NotImplemented 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: NotImplemented.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_NotImplemented 异常指示某个方法没有实现
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_NotImplemented extends FLEA_Exception
{
    var $className;
    var $methodName;

    /**
     * 构造函数
     *
     * @param string $method
     * @param string $class
     *
     * @return FLEA_Exception_NotImplemented
     */
    function FLEA_Exception_NotImplemented($method, $class = '') {
        $this->className = $class;
        $this->methodName = $method;
        if ($class) {
            $code = 0x010200a;
            parent::FLEA_Exception(sprintf(_E($code), $class, $method));
        } else {
            $code = 0x010200b;
            parent::FLEA_Exception(sprintf(_E($code), $method));
        }
    }
}
