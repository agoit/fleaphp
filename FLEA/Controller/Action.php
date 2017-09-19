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
 * 定义 FLEA_Controller_Action 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: Action.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Controller_Action 实现了一个其它控制器的超类，
 * 为开发者自己的控制器提供了一些方便的成员变量和方法
 *
 * 开发者不一定需要从这个类继承来构造自己的控制器。
 * 但从这个类派生自己的控制器可以获得一些便利性。
 *
 * @package Core
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Controller_Action
{
    /**
     * 当前控制的名字，用于 $this->url() 方法
     *
     * @var string
     */
    var $_controllerName;

    /**
     * 构造函数
     *
     * 继承类如果有构造函数，必须调用 FLEA_Controller_Action 的构造函数，并传入控制器名字。
     *
     * @param string $controllerName
     *
     * @return FLEA_Controller_Action
     */
    function FLEA_Controller_Action($controllerName) {
        log_message('Construction FLEA_Controller_Action', 'debug');
        $this->_controllerName = $controllerName;
    }

    /**
     * 设置控制器名字，由 dispatcher 调用
     *
     * @param string $controllerName
     */
    function __setController($controllerName) {
        $this->_controllerName = $controllerName;
    }

    /**
     * 获得当前使用的 Dispatcher
     *
     * @return FLEA_Dispatcher_Simple
     */
    function & _getDispatcher() {
        return get_singleton(get_app_inf('dispatcher'));
    }

    /**
     * 构造当前控制器的 url 地址
     *
     * @param string $actionName
     * @param array $args
     *
     * @return string
     */
    function _url($actionName = null, $args = null) {
        return url($this->_controllerName, $actionName, $args);
    }

    /**
     * 转发请求到另一个控制器方法
     *
     * @param string $controllerName
     * @param string $actionName
     */
    function _forward($controllerName, $actionName) {
        $_GET[get_app_inf('controllerAccessor')] = $controllerName;
        $_GET[get_app_inf('actionAccessor')] = $actionName;
        $dispatcher =& get_singleton(get_app_inf('dispatcher'));
        $dispatcher->dispatching($_GET);
    }

    /**
     * 返回视图对象
     *
     * @return object
     */
    function & _getView() {
        $viewClass = get_app_inf('view');
        if ($viewClass != 'PHP') {
            $view =& get_singleton($viewClass);
            return $view;
        } else {
            $view = false;
            return $view;
        }
    }


    /**
     * 执行指定的视图
     *
     * @param string $__flea_internal_viewName
     * @param array $data
     */
    function _executeView($__flea_internal_viewName, $data = null) {
        $viewClass = get_app_inf('view');
        if ($viewClass == 'PHP') {
            if (is_array($data)) { extract($data); }
            include($__flea_internal_viewName);
        } else {
            $view =& $this->_getView();
            if (is_array($data)) { $view->assign($data); }
            $view->display($__flea_internal_viewName);
        }
    }

    /**
     * 判断 HTTP 请求是否是 POST 方法
     *
     * @return boolean
     */
    function _isPOST() {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
    }
}
