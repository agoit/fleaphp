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
 * 定义 FLEA_Dispatcher_Exception_CheckFailed 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: CheckFailed.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Dispatcher_Exception_CheckFailed 异常指示用户试图访问的控制器方法不允许该用户访问
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Dispatcher_Exception_CheckFailed extends FLEA_Exception
{
    var $controllerName;
    var $actionName;

    /**
     * 构造函数
     *
     * @param string $controllerName
     * @param string $actionName
     *
     * @return FLEA_Dispatcher_Exception_CheckFailed
     */
    function FLEA_Dispatcher_Exception_CheckFailed($controllerName, $actionName) {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $code = 0x0701004;
        $msg = sprintf(_E($code), $controllerName, $actionName);
        parent::FLEA_Exception($msg, $code);
    }
}
