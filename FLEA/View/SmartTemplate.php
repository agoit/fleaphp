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
* 定义 FLEA_View_SmartTemplate 类
*
* @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
* @author 小龙 xlonecn@msn.com
* @package Core
* @version $Id: SmartTemplate.php 640 2006-12-19 11:51:09Z dualface $
*/

// {{{ includes

if (!class_exists('SmartTemplate')) {
    $viewConfig = get_app_inf('viewConfig');
    if (!isset($viewConfig['smartyDir'])) {
        load_class('FLEA_View_Exception_NotConfigurationSmartTemplate');
        __THROW(new FLEA_View_Exception_NotConfigurationSmartTemplate());
        return false;
    }

    $filename = $viewConfig['smartyDir'] . '/class.smarttemplate.php';
    if (!is_readable($filename)) {
        load_class('FLEA_View_Exception_InitSmartTemplateFailed');
        __THROW(new FLEA_View_Exception_InitSmartTemplateFailed($filename));
        return false;
    }
    require($filename);
}

// }}}

/**
* FLEA_View_SmartTemplate 提供了对 SmartTemplate 模板引擎的支持
*
* @author 小龙 xlonecn@msn.com
* @package Core
* @version 1.0
*/
class FLEA_View_SmartTemplate extends SmartTemplate
{
    /**
     * 构造函数
     *
     * @return FLEA_View_SmartTemplate
     */
    function FLEA_View_SmartTemplate()
    {
        log_message('Construction FLEA_View_SmartTemplate', 'debug');
        parent::SmartTemplate();

        $viewConfig = get_app_inf('viewConfig');
        if (!is_array($viewConfig)) {
            return;
        }

        foreach ($viewConfig as $key => $value) {
            if (isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * 输出指定模版的内容
     *
     * @param string $tpl
     */
    function display($tpl)
    {
        $this->tpl_file = $tpl;
        parent::output();
    }
}
