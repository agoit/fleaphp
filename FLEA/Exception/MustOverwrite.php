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
 * 定义 FLEA_Exception_MustOverwrite 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: MustOverwrite.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_MustOverwrite 异常指示某个方法必须在派生类中重写
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_MustOverwrite extends FLEA_Exception
{
    var $prototypeMethod;

    /**
     * 构造函数
     *
     * @param string $prototypeMethod
     *
     * @return FLEA_Exception_MustOverwrite
     */
    function FLEA_Exception_MustOverwrite($prototypeMethod) {
        $this->prototypeMethod = $prototypeMethod;
        $code = 0x0102008;
        $msg = sprintf(_E($code), $prototypeMethod);
        parent::FLEA_Exception($msg, $code);
    }
}
