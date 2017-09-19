<?php
/////////////////////////////////////////////////////////////////////////////
// ����ļ��� FleaPHP ��Ŀ��һ����
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// Ҫ�鿴�����İ�Ȩ��Ϣ�������Ϣ����鿴Դ�����и����� COPYRIGHT �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * ���� FLEA_Dispatcher_Simple ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: Simple.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Dispatcher_Simple ���� HTTP ���󣬲�ת�������ʵ� Controller ������
 *
 * @package Core
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Dispatcher_Simple
{
    function FLEA_Dispatcher_Simple() {
        log_message('Construction FLEA_Dispatcher_Simple', 'debug');
    }

    /**
     * �������з��� Controller��Action �� Package ���֣�Ȼ��ִ��ָ���� Action ����
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
     * ִ��ָ���� Action ����
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
            // ִ�� action ����
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
     * ��������ȡ�� Controller ����
     *
     * ���û��ָ�� Controller ���֣��򷵻������ļ��ж����Ĭ�� Controller ���֡�
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
     * ��������ȡ�� Action ����
     *
     * ���û��ָ�� Action ���֣��򷵻������ļ��ж����Ĭ�� Action ���֡�
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
     * ����ָ����������Ӧ��������
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
