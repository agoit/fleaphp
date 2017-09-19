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
* ���� FLEA_View_SmartTemplate ��
*
* @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
* @author С�� xlonecn@msn.com
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
* FLEA_View_SmartTemplate �ṩ�˶� SmartTemplate ģ�������֧��
*
* @author С�� xlonecn@msn.com
* @package Core
* @version 1.0
*/
class FLEA_View_SmartTemplate extends SmartTemplate
{
    /**
     * ���캯��
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
     * ���ָ��ģ�������
     *
     * @param string $tpl
     */
    function display($tpl)
    {
        $this->tpl_file = $tpl;
        parent::output();
    }
}
