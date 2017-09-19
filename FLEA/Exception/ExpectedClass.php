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
 * 定义 FLEA_Exception_ExpectedClass 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: ExpectedClass.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_ExpectedClass 异常指示需要的类没有找到
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_ExpectedClass extends FLEA_Exception
{
    var $className;
    var $classFile;

    /**
     * 构造函数
     *
     * @param string $className
     * @param string $file
     *
     * @return FLEA_Exception_ExpectedClass
     */
    function FLEA_Exception_ExpectedClass($className, $file = null) {
        $this->className = $className;
        $this->classFile = $file;
        if ($file) {
            $code = 0x0102002;
            $msg = sprintf(_E($code), $file, $className);
        } else {
            $code = 0x0102003;
            $msg = sprintf(_E($code), $className);
        }
        parent::FLEA_Exception($msg, $code);
    }
}
