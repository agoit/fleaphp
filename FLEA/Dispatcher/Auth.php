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
 * ���� FLEA_Dispatcher_Auth ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: Auth.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ includes
load_class('FLEA_Dispatcher_Simple');
// }}}

/**
 * FLEA_Dispatcher_Auth ���� HTTP ���󣬲�ת�������ʵ� Controller ������
 *
 * @package Core
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Dispatcher_Auth extends FLEA_Dispatcher_Simple
{
    function FLEA_Dispatcher_Auth() {
        log_message('Construction FLEA_Dispatcher_Auth', 'debug');
        parent::FLEA_Dispatcher_Simple();
    }

    /**
     * ִ�п���������
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
            // ���ͨ����ִ�п���������
            return $this->_executeAction($controllerName, $actionName, $controllerClass);
        } else {
            // ���ʧ��
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
     * ��鵱ǰ�û��Ƿ���Ȩ�޷���ָ���Ŀ������ͷ���
     *
     * ��֤�������£�
     *
     * 1��ͨ�� authProiver ��ȡ��ǰ�û��Ľ�ɫ��Ϣ��
     * 2������ getControllerACT() ��ȡָ���������ķ��ʿ��Ʊ�
     * 3������ ACT ���û���ɫ���м�飬ͨ���򷵻� true�����򷵻� false��
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
        // ���������û���ṩ ACT�������ṩ��һ���յ� ACT����ٶ������û�����
        $rawACT = $this->getControllerACT($controllerName, $controllerClass);
        if ($rawACT == null || empty($rawACT)) { return true; }

        // ȡ����֤����Ӧ��
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
        // ȡ���û���ɫ��Ϣ
        $roles = $auth->getRolesArray();
        // ���ȼ���û��Ƿ���Է��ʸÿ�����
        if (!$auth->check($roles, $ACT)) { return false; }

        // ��������֤�û��Ƿ���Է���ָ���Ŀ���������
        $actionName = strtolower($actionName);
        if (!isset($ACT['actions'][$actionName])) { return true; }
        return $auth->check($roles, $ACT['actions'][$actionName]);
    }

    /**
     * ��ȡָ���������ķ��ʿ��Ʊ�ACT��
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
     * ��Ĭ�� ACT �ļ�������ָ���������� ACT
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
     * ���� ACT �ļ�
     *
     * @param string $actFilename
     *
     * @return mixed
     */
    function _loadACTFile($actFilename) {
        $ACT = require($actFilename);
        if (is_array($ACT)) { return $ACT; }

        // ���������� ACT �ļ�û�з��� ACT ʱ�׳��쳣
        load_class('FLEA_Com_RBAC_Exception_InvalidACTFile');
        __THROW(new FLEA_Com_RBAC_Exception_InvalidACTFile($actFilename, $ACT));
        return false;
    }
}
