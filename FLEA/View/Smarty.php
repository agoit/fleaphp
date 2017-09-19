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
 * 定义 FLEA_View_Smarty 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: Smarty.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ includes

if (!class_exists('Smarty')) {
    $viewConfig = get_app_inf('viewConfig');
    if (!isset($viewConfig['smartyDir']) && !defined('SMARTY_DIR')) {
        load_class('FLEA_View_Exception_NotConfigurationSmarty');
        __THROW(new FLEA_View_Exception_NotConfigurationSmarty());
    }

    $filename = $viewConfig['smartyDir'] . '/Smarty.class.php';
    if (!is_readable($filename)) {
        load_class('FLEA_View_Exception_InitSmartyFailed');
        __THROW(new FLEA_View_Exception_InitSmartyFailed($filename));
    }
    require($filename);
}

// }}}

/**
 * FLEA_View_Smarty 提供了对 Smarty 模板引擎的支持
 *
 * @package Core
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_View_Smarty extends Smarty
{
    /**
     * 构造函数
     *
     * @return FLEA_View_Smarty
     */
    function FLEA_View_Smarty() {
        log_message('Construction FLEA_View_Smarty', 'debug');
        parent::Smarty();

        $viewConfig = get_app_inf('viewConfig');
        if (!is_array($viewConfig)) {
            return;
        }

        foreach ($viewConfig as $key => $value) {
            if (isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }

        $this->register_function('url', array(& $this, '_pi_func_url'));
    }

    /**
     * 自定义的 Smarty 函数 url 调用 FleaPHP 的 url 函数生成 URL 地址
     *
     * @param array $params
     * @param Smarty $smarty
     */
    function _pi_func_url($params, & $smarty) {
        $controllerName = isset($params['controller'])
            ? $params['controller'] : get_app_inf('defaultController');
        $actionName = isset($params['action'])
            ? $params['action'] : get_app_inf('defaultAction');
        $mode = isset($params['mode']) ? $params['mode'] : null;

        $args = array();
        if (isset($params['args'])) {
            $parts = explode('&', $params['args']);
            foreach ($parts as $part) {
                list($key, $value) = explode('=', $part);
                $args[$key] = $value;
            }
        }
        return url($controllerName, $actionName, $args, $mode);
    }
}
