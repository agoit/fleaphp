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
 * ���� FLEA_Controller_Action ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: Action.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Controller_Action ʵ����һ�������������ĳ��࣬
 * Ϊ�������Լ��Ŀ������ṩ��һЩ����ĳ�Ա�����ͷ���
 *
 * �����߲�һ����Ҫ�������̳��������Լ��Ŀ�������
 * ��������������Լ��Ŀ��������Ի��һЩ�����ԡ�
 *
 * @package Core
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Controller_Action
{
    /**
     * ��ǰ���Ƶ����֣����� $this->url() ����
     *
     * @var string
     */
    var $_controllerName;

    /**
     * ���캯��
     *
     * �̳�������й��캯����������� FLEA_Controller_Action �Ĺ��캯������������������֡�
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
     * ���ÿ��������֣��� dispatcher ����
     *
     * @param string $controllerName
     */
    function __setController($controllerName) {
        $this->_controllerName = $controllerName;
    }

    /**
     * ��õ�ǰʹ�õ� Dispatcher
     *
     * @return FLEA_Dispatcher_Simple
     */
    function & _getDispatcher() {
        return get_singleton(get_app_inf('dispatcher'));
    }

    /**
     * ���쵱ǰ�������� url ��ַ
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
     * ת��������һ������������
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
     * ������ͼ����
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
     * ִ��ָ������ͼ
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
     * �ж� HTTP �����Ƿ��� POST ����
     *
     * @return boolean
     */
    function _isPOST() {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
    }
}
