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
 * FleaPHP Ӧ�ó����Ĭ������
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Config
 * @version $Id: Default_APP_INF.php 640 2006-12-19 11:51:09Z dualface $
 */

return array(
    // {{{ ��������

    /**
     * Ӧ�ó����Ĭ�����ֿռ�
     */
    'namespace'                 => '',

    /**
     * ָʾ�������� url ��������Ĭ�Ͽ�������
     *
     * ����������ֻ����a-z��ĸ��0-9���֣��Լ���_���»��ߡ�
     */
    'controllerAccessor'        => 'controller',
    'defaultController'         => 'Default',

    /**
     * ָʾ ���������� url ��������Ĭ�� ����������
     */
    'actionAccessor'            => 'action',
    'defaultAction'             => 'index',

    /**
     * url �����Ĵ���ģʽ�������Ǳ�׼��PATHINFO��URL ��д��ģʽ
     */
    'urlMode'                   => URL_STANDARD,

    /**
     * �Ƿ� url �����а����Ŀ��������ֺͶ�������ǿ��תΪСд
     */
    'urlLowerChar'              => false,

    /**
     * ������������ǰ׺
     */
    'controllerClassPrefix'     => 'Controller_',

    /**
     * �������У�������������ǰ׺�ͺ�׺
     * ʹ��ǰ׺�ͺ�׺���Խ�һ�������������е�˽�з���
     */
    'actionMethodPrefix'        => 'action',
    'actionMethodSuffix'        => '',

    /**
     * Ӧ�ó���Ҫʹ�õ� url ������
     */
    'dispatcher'                => 'FLEA_Dispatcher_Simple',

    /**
     * ����������ʧ�ܣ��������������������������ڣ���Ҫ���õĴ������
     */
    'dispatcherFailedCallback'  => null,

    /**
     * FleaPHP �ڲ��� cache ϵ�к���ʹ�õĻ���Ŀ¼
     */
    'internalCacheDir'          => FLEA_DIR . DS . '_Cache',

    /**
     * ָʾҪ�Զ�������ļ�
     */
    'autoLoad'                  => array(
        'FLEA_Helper_Array.php',
        'FLEA_Helper_Html.php',
        'FLEA_Controller_Action.php',
    ),

    /**
     * ָʾ�Ƿ����� session �ṩ����
     */
    'sessionProvider'           => null,

    /**
     * ָʾ�Ƿ��Զ����� session ֧��
     */
    'autoSessionStart'          => true,

    /**
     * ָʾʹ����Щ�������� HTTP ������й���
     */
    'requestFilters'            => array(),

    // }}}

    // {{{ ���ݿ����

    /**
     * ���ݿ����ã����������飬Ҳ������ DSN �ַ���
     */
    'dbDSN'                     => null,

    /**
     * ָʾ���� TableDataGateway ����ʱ���Ƿ��Զ����ӵ����ݿ�
     */
    'dbTDGAutoInit'             => true,

    /**
     * ���ݱ��ȫ��ǰ׺
     */
    'dbTablePrefix'             => '',

    /**
     * TableDataGateway Ҫʹ�õ�������֤�������
     */
    'dbValidationProvider'      => 'FLEA_Helper_Validation',

    // }}}

    // {{{ View ���

    /**
     * Ҫʹ�õ�ģ�����棬'PHP' ��ʾʹ�� PHP ���Ա�����ģ������
     */
    'view'                      => 'PHP',

    /**
     * ģ������Ҫʹ�õ�������Ϣ
     */
    'viewConfig'                => null,

    // }}}

    // {{{ I18N

    /**
     * ָʾ FleaPHP Ӧ�ó����ڲ��������ݺ��������Ҫʹ�õı���
     */
    'responseCharset'           => 'gb2312',

    /**
     * �� FleaPHP �������ݿ�ʱ����ʲô���봫������
     */
    'databaseCharset'           => 'gb2312',

    /**
     * �Ƿ��Զ���� Content-Type: text/html; charset=responseCharset
     */
    'autoResponseHeader'        => true,

    /**
     * �Ƿ��Զ����� RESPONSE_CHARSET��DATABASE_CHARSET �ȳ���
     */
    'charsetConstant'           => true,

    /**
     * ָʾ�Ƿ����ö�����֧��
     */
    'multiLangaugeSupport'      => false,

    /**
     * ָ���ṩ������֧�ֵ��ṩ����
     */
    'languageSupportProvider'   => 'FLEA_Com_Language',

    /**
     * ָʾ�����ļ��ı���λ��
     */
    'languageFilesDir'          => null,

    /**
     * ָʾĬ������
     */
    'defaultLanguage'           => 'chinese-gb2312',

    /**
     * �Զ�����������ļ�
     */
    'autoLoadLanguage'          => null,

    // }}}

    // {{{ FLEA_Dispatcher_Auth �� RBAC ���

    /**
     * ������Ҫʹ�õ���֤�����ṩ����
     */
    'dispatcherAuthProvider'    => 'FLEA_Com_RBAC',

    /**
     * ָʾ RBAC ���Ҫʹ�õ�Ĭ�� ACT �ļ�
     */
    'defaultControllerACTFile'  => '',

    /**
     * ָʾ RBAC ����Ƿ���û���ҵ��������� ACT �ļ�ʱ��
     * �Ƿ��Ĭ�� ACT �ļ��в�ѯ�������� ACT
     */
    'autoQueryDefaultACTFile'   => false,

    /**
     * ��������û���ṩ ACT �ļ�ʱ����ʾ������Ϣ
     */
    'controllerACTLoadWarning'  => true,

    /**
     * ָʾ��û��Ϊ�������ṩ ACT ʱ��Ҫʹ�õ�Ĭ�� ACT
     */
    'defaultControllerACT'      => null,

    /**
     * �û�û��Ȩ�޷��ʿ����������������ʱ��Ҫ���õĴ������
     */
    'dispatcherAuthFailedCallback' => null,

    /**
     * ָʾ RBAC �����ʲô������ session �б����û�����
     * �����һ��������ͬʱ���ж��Ӧ�ó��������Ϊÿһ��Ӧ�ó���ʹ���Լ���һ�޶��ļ���
     */
    'RBACSessionKey'            => 'RBAC_USERDATA',

    // }}}

    // {{{ ��־�ʹ�����
    /**
     * ָʾ�Ƿ�������־����
     */
    'logEnabled'                => false,

    /**
     * ָʾ��־����ĳ���
     */
    'logProvider'               => 'FLEA_Com_Log',

    /**
     * ָʾ��ʲôĿ¼������־�ļ�
     */
    'logFileDir'                => null,

    /**
     * ָʾ��ʲô�ļ���������־
     */
    'logFilename'               => 'access.log',

    /**
     * ָʾ����־�ļ��������� KB ʱ���Զ������µ���־�ļ�����λ�� KB������С�� 512KB
     */
    'logFileMaxSize'            => 4096,

    /**
     * ָʾ��Щ����Ĵ���Ҫ���浽��־��
     */
    'logErrorLevel'             => 'warning, error, exception',

    /**
     * ָʾ�Ƿ���ʾ������Ϣ
     */
    'displayErrors'             => true,

    /**
     * ָʾ�Ƿ���ʾ�ѺõĴ�����Ϣ
     */
    'friendlyErrorsMessage'     => true,

    // }}}
);
