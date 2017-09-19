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
 * 定义 FLEA_Dispatcher_Auth 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: Auth.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ includes
load_class('FLEA_Dispatcher_Simple');
// }}}

/**
 * FLEA_Dispatcher_Auth 分析 HTTP 请求，并转发到合适的 Controller 对象处理
 *
 * @package Core
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Dispatcher_Auth extends FLEA_Dispatcher_Simple
{
    function FLEA_Dispatcher_Auth() {
        log_message('Construction FLEA_Dispatcher_Auth', 'debug');
        parent::FLEA_Dispatcher_Simple();
    }

    /**
     * 执行控制器方法
     *
     * @param array $request
     *
     * @return mixed
     */
    function dispatching(& $request) {
        $controllerName  = $this->getControllerName($request);
        $actionName      = $this->getActionName($request);
        $controllerClass = $this->getControllerClass($controllerName);

        log_message(sprintf('FLEA_Dispatcher_Auth::dispatching(%s, %s)',
            $controllerName, $actionName),
            'debug');

        if ($this->check($controllerName, $actionName, $controllerClass)) {
            // 检查通过，执行控制器方法
            return $this->_executeAction($controllerName, $actionName, $controllerClass);
        } else {
            // 检查失败
            log_message(sprintf('FLEA_Dispatcher_Auth::check(%s, %s) failed',
                $controllerName, $actionName),
                'debug');

            $callback = get_app_inf('dispatcherAuthFailedCallback');
            if ($callback) {
                $args = array($controllerName, $actionName, $controllerClass);
                return call_user_func_array($callback, $args);
            } else {
                load_class('FLEA_Dispatcher_Exception_CheckFailed');
                __THROW(new FLEA_Dispatcher_Exception_CheckFailed($controllerName,
                    $actionName));
                return false;
            }
        }
    }

    /**
     * 检查当前用户是否有权限访问指定的控制器和方法
     *
     * 验证步骤如下：
     *
     * 1、通过 authProiver 获取当前用户的角色信息；
     * 2、调用 getControllerACT() 获取指定控制器的访问控制表；
     * 3、根据 ACT 对用户角色进行检查，通过则返回 true，否则返回 false。
     *
     * @param string $controllerName
     * @param string $actionName
     * @param string $controllerClass
     *
     * @return boolean
     */
    function check($controllerName, $actionName, $controllerClass = null) {
        if ($controllerClass == null) {
            $controllerClass = $this->getControllerClass($controllerName);
        }
        // 如果控制器没有提供 ACT，或者提供了一个空的 ACT，则假定允许用户访问
        $rawACT = $this->getControllerACT($controllerName, $controllerClass);
        if ($rawACT == null || empty($rawACT)) { return true; }

        // 取得验证服务供应者
        $auth =& get_singleton(get_app_inf('dispatcherAuthProvider'));
        /* @var $auth FLEA_Com_RBAC */
        $ACT = $auth->prepareACT($rawACT);
        $ACT['actions'] = array();
        if (isset($rawACT['actions']) && is_array($rawACT['actions'])) {
            foreach ($rawACT['actions'] as $rawActionName => $rawActionACT) {
                $rawActionName = strtolower($rawActionName);
                $ACT['actions'][$rawActionName] = $auth->prepareACT($rawActionACT);
            }
        }
        // 取出用户角色信息
        $roles = $auth->getRolesArray();
        // 首先检查用户是否可以访问该控制器
        if (!$auth->check($roles, $ACT)) { return false; }

        // 接下来验证用户是否可以访问指定的控制器方法
        $actionName = strtolower($actionName);
        if (!isset($ACT['actions'][$actionName])) { return true; }
        return $auth->check($roles, $ACT['actions'][$actionName]);
    }

    /**
     * 获取指定控制器的访问控制表（ACT）
     *
     * @param string $controllerName
     * @param string $controllerClass
     *
     * @return array
     */
    function getControllerACT($controllerName, $controllerClass) {
        $actFilename = get_file_path($controllerClass . '.act.php');
        if (!$actFilename) {
            if (get_app_inf('autoQueryDefaultACTFile')) {
                $ACT = $this->getControllerACTFromDefaultFile($controllerName);
                if ($ACT) { return $ACT; }
            }

            if (get_app_inf('controllerACTLoadWarning')) {
                trigger_error("Controller '{$controllerName}' haven't ACT file.",
                    E_USER_WARNING);
            }
            return get_app_inf('defaultControllerACT');
        }

        return $this->_loadACTFile($actFilename);
    }

    /**
     * 从默认 ACT 文件中载入指定控制器的 ACT
     *
     * @param string $controllerName
     */
    function getControllerACTFromDefaultFile($controllerName) {
        $actFilename = realpath(get_app_inf('defaultControllerACTFile'));
        if (!$actFilename) {
            if (get_app_inf('controllerACTLoadWarning')) {
                trigger_error("Controller '{$controllerName}' haven't ACT file.",
                    E_USER_WARNING);
            }
            return get_app_inf('defaultControllerACT');
        }

        $ACT = $this->_loadACTFile($actFilename);
        if ($ACT === false) { return false; }

        $ACT = array_change_key_case($ACT, CASE_UPPER);
        $controllerName = strtoupper($controllerName);
        return isset($ACT[$controllerName]) ?
            $ACT[$controllerName] :
            get_app_inf('defaultControllerACT');
    }

    /**
     * 载入 ACT 文件
     *
     * @param string $actFilename
     *
     * @return mixed
     */
    function _loadACTFile($actFilename) {
        $ACT = require($actFilename);
        if (is_array($ACT)) { return $ACT; }

        // 当控制器的 ACT 文件没有返回 ACT 时抛出异常
        load_class('FLEA_Com_RBAC_Exception_InvalidACTFile');
        __THROW(new FLEA_Com_RBAC_Exception_InvalidACTFile($actFilename, $ACT));
        return false;
    }
}
