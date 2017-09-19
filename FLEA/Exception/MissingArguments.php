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
 * 定义 FLEA_Exception_MissingArguments 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: MissingArguments.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_MissingArguments 异常指示缺少必须的参数
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_MissingArguments extends FLEA_Exception
{
    /**
     * 缺少的参数
     *
     * @var mixed
     */
    var $args;

    /**
     * 构造函数
     *
     * @param mixed $args
     *
     * @return FLEA_Exception_MissingArguments
     */
    function FLEA_Exception_MissingArguments($args) {
        $this->args = $args;
        if (is_array($args)) {
            $args = implode(', ', $args);
        }
        $code = 0x0102007;
        $msg = sprintf(_E($code), $args);
        parent::FLEA_Exception($msg, $code);
    }
}
