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
 * 定义 FLEA_Exception_MissingAction 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: MissingAction.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_MissingAction 指示请求的控制器 Action 方法没有找到
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_MissingAction extends FLEA_Exception
{
    /**
     * 控制器的名字
     *
     * @var string
     */
    var $controller;

    /**
     * Action 方法名字
     *
     * @var string
     */
    var $action;

    /**
     * 调用参数
     *
     * @var unknown_type
     */
    var $arguments;

    /**
     * 构造函数
     *
     * @param string $controller
     * @param string $action
     * @param mixed $arguments
     *
     * @return FLEA_Exception_MissingAction
     */
    function FLEA_Exception_MissingAction($controller, $action, $arguments = null) {
        $this->controller = $controller;
        $this->action = $action;
        $this->arguments = $arguments;
        $code = 0x0103001;
        $msg = sprintf(_E($code), $controller, $action);
        parent::FLEA_Exception($msg, $code);
    }
}
