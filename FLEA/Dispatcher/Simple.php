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
 * 定义 FLEA_Dispatcher_Simple 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: Simple.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Dispatcher_Simple 分析 HTTP 请求，并转发到合适的 Controller 对象处理
 *
 * @package Core
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Dispatcher_Simple
{
    function FLEA_Dispatcher_Simple() {
        log_message('Construction FLEA_Dispatcher_Simple', 'debug');
    }

    /**
     * 从请求中分析 Controller、Action 和 Package 名字，然后执行指定的 Action 方法
     *
     * @param array $request
     *
     * @return mixed
     */
    function dispatching(& $request) {
        $controllerName = $this->getControllerName($request);
        $actionName = $this->getActionName($request);
        log_message(sprintf('FLEA_Dispatcher_Simple::dispatching(%s, %s)',
            $controllerName, $actionName),
            'debug');
        return $this->_executeAction($controllerName,
            $actionName,
            $this->getControllerClass($controllerName)
        );
    }

    /**
     * 执行指定的 Action 方法
     *
     * @param array $request
     * @param string $controllerName
     * @param string $actionName
     * @param string $controllerClass
     *
     * @return mixed
     */
    function _executeAction($controllerName, $actionName, $controllerClass) {
        $callback = get_app_inf('dispatcherFailedCallback');
        $controller = null;
        do {
            __TRY();
            load_class($controllerClass);
            $ex = __CATCH();
            if (__IS_EXCEPTION($ex)) { break; }

            $controller =& new $controllerClass($controllerName);
            $actionPrefix = get_app_inf('actionMethodPrefix');
            if ($actionPrefix != '') { $actionName = ucfirst($actionName); }
            $actionMethod = $actionPrefix . $actionName . get_app_inf('actionMethodSuffix');
            if (!method_exists($controller, $actionMethod)) { break; }
            if (method_exists($controller, '__setController')) {
                $controller->__setController($controllerName);
            }
            // 执行 action 方法
            return $controller->{$actionMethod}();
        } while (false);

        if ($callback) {
            $args = array($controllerName, $actionMethod, $controllerClass);
            return call_user_func_array($callback, $args);
        }

        if (!$controller) {
            load_class('FLEA_Exception_MissingController');
            __THROW(new FLEA_Exception_MissingController($controllerName, $actionName));
            return false;
        }
        load_class('FLEA_Exception_MissingAction');
        __THROW(new FLEA_Exception_MissingAction($controllerName, $actionMethod));
        return false;
    }

    /**
     * 从请求中取得 Controller 名字
     *
     * 如果没有指定 Controller 名字，则返回配置文件中定义的默认 Controller 名字。
     *
     * @param array $request
     *
     * @return string
     */
    function getControllerName(& $request) {
        $controllerAccessor = get_app_inf('controllerAccessor');
        if (isset($request[$controllerAccessor]) &&
            trim($request[$controllerAccessor]) != '')
        {
            $controllerName = trim($request[$controllerAccessor]);
        } else {
            $controllerName = get_app_inf('defaultController');
        }
        $controllerName = preg_replace('/[^a-z0-9_]+/i', '', $controllerName);

        if (get_app_inf('urlLowerChar')) {
            $controllerName = strtolower($controllerName);
        }

        return $controllerName;
    }

    /**
     * 从请求中取得 Action 名字
     *
     * 如果没有指定 Action 名字，则返回配置文件中定义的默认 Action 名字。
     *
     * @param array $request
     *
     * @return string
     */
    function getActionName(& $request) {
        $actionAccessor = get_app_inf('actionAccessor');
        if (isset($request[$actionAccessor]) && trim($request[$actionAccessor]) != '') {
            $actionName = trim($request[$actionAccessor]);
        } else {
            $actionName = get_app_inf('defaultAction');
        }
        return preg_replace('/[^a-z0-9]+/i', '', $actionName);
    }

    /**
     * 返回指定控制器对应的类名称
     *
     * @param string $controllerName
     *
     * @return string
     */
    function getControllerClass($controllerName) {
        $namespace = get_app_inf('namespace');
        if ($namespace != '') {
            $prefix = $namespace . '_';
        } else {
            $prefix = '';
        }
        $controllerClass = $prefix . get_app_inf('controllerClassPrefix');
        if (get_app_inf('urlLowerChar')) {
            $controllerClass .= ucfirst(strtolower($controllerName));
        } else {
            $controllerClass .= $controllerName;
        }
        return $controllerClass;
    }
}
