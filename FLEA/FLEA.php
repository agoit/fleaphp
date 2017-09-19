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
 * ��ʼ�� FleaPHP ���л���
 *
 * ���ڴ󲿷� FleaPHP ���������Ҫ��Ԥ�ȳ�ʼ�� FleaPHP ������
 * ��Ӧ�ó�����ֻ��Ҫͨ�� require('FLEA/FLEA.php'); ������ļ���
 * ������� FleaPHP ���л����ĳ�ʼ��������
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: FLEA.php 686 2007-01-06 20:30:22Z dualface $
 */

// {{{ constants

/**
 * �����ļ������ʱ��
 */
global $___fleaphp_loaded_time;
$___fleaphp_loaded_time = microtime();

/**
 * ���� FleaPHP �汾�ų���
 */
define('FLEA_VERSION', '1.0.61.686');

/**
 * ����ָʾ PHP4 �� PHP5 �ĳ���
 */
if (substr(PHP_VERSION, 0, 1) == '5') {
    define('PHP5', true);
} else {
    define('PHP4', true);
}

/**
 * ��д�� DIRECTORY_SEPARATOR
 */
define('DS', DIRECTORY_SEPARATOR);

/**#@+
 * ������õ� URL ģʽ
 */
/**
 * ��׼ URL ģʽ
 */
define('URL_STANDARD',  1);

/**
 * PATHINFO ģʽ
 */
define('URL_PATHINFO',  2);

/**
 * URL ��дģʽ
 */
define('URL_REWRITE',   3);
/**#@-*/

/**#@+
 * ���� RBAC ������ɫ����
 */
/**
 * RBAC_EVERYONE ��ʾ�κ��û������ܸ��û��Ƿ���н�ɫ��Ϣ��
 */
define('RBAC_EVERYONE',     -1);

/**
 * RBAC_HAS_ROLE ��ʾ�����κν�ɫ���û�
 */
define('RBAC_HAS_ROLE',     -2);

/**
 * RBAC_NO_ROLE ��ʾ�������κν�ɫ���û�
 */
define('RBAC_NO_ROLE',      -3);

/**
 * RBAC_NULL ��ʾ������û��ֵ
 */
define('RBAC_NULL',         null);
/**#@-*/

// }}}

// {{{ init

/**
 * ��ʼ�� FleaPHP Ҫʹ�õ�ȫ�ֱ���
 */
define('G_FLEA_VAR', '__FLEA_CORE__');
$GLOBALS[G_FLEA_VAR] = array(
    'APP_INF'                => array(),
    'OBJECTS'                => array(),
    'CLASS_PATH'             => array(),
    'FLEA_EXCEPTION_STACK'   => array(),
    'FLEA_EXCEPTION_HANDLER' => null,
);

/**
 * ���� FleaPHP �ļ�����λ�ã��Լ���ʼ�� CLASS_PATH
 */
define('FLEA_DIR', dirname(__FILE__));
$GLOBALS[G_FLEA_VAR]['CLASS_PATH'] = array(dirname(FLEA_DIR));

/**
 * ������ PHP5 ������ʱ�����ľ�����Ϣ
 */
if (!defined('E_STRICT')) {
    define('E_STRICT', 2048);
}
error_reporting(error_reporting(0) & ~E_STRICT);

/**
 * ����Ĭ�������ļ�
 */
$GLOBALS[G_FLEA_VAR]['APP_INF'] = (array)require(FLEA_DIR . '/Config/Default_APP_INF.php');

/**
 * �������������
 */
require(FLEA_DIR . '/StdLibs.php');

/**
 * ��������쳣���壬�������쳣��������
 */
if (defined('PHP5')) {
    require(FLEA_DIR . '/ExceptionPHP5.php');
} else {
    require(FLEA_DIR . '/ExceptionPHP4.php');
}
__SET_EXCEPTION_HANDLER('__FLEA_EXCEPTION_HANDLER');
// }}}

// {{{ prepare runtime
/**
 * ׼�����л��������������ļ������й����������� session ��
 *
 * __FLEA_PREPARE() ����Ӧ�ó������ã�����Զ������ļ������������������
 * �� session ֧�ֵ�����
 *
 * ���Ӧ�ó���ʹ�� run() �������� MVC ģʽ����ô __FLEA_PREPARE() ����
 * �ᱻ�Զ����á����򿪷��߿���ѡ���Լ����� __FLEA_PREPARE() ��׼�����л�����
 */
function __FLEA_PREPARE() {
    static $firstTime = true;

    // �����ظ����� __FLEA_PREPARE()
    if (!$firstTime) { return; }
    $firstTime = false;

    /**
     * ������־�����ṩ����
     */
    if (get_app_inf('logProvider') && get_app_inf('logEnabled')) {
        load_class(get_app_inf('logProvider'));
    }
    if (!function_exists('log_message')) {
        // ���û��ָ����־�����ṩ���򣬾Ͷ���һ���յ� log_message() ����
        eval('function log_message() {}');
    }

    log_message('__FLEA_PREPARE()', 'debug');

    // ���� magic_quotes
    if (get_magic_quotes_gpc()) {
        require(FLEA_DIR . '/Filter/MagicQuotes.php');
    }
    set_magic_quotes_runtime(0);

    // ���� URL ģʽ���ã������Ƿ�Ҫ���� URL ����������
    if (get_app_inf('urlMode') != URL_STANDARD) {
        require(FLEA_DIR . '/Filter/Uri.php');
    }

    // ���� requestFilters
    foreach ((array)get_app_inf('requestFilters') as $file) {
        load_file($file);
    }

    // ���� autoLoad
    foreach ((array)get_app_inf('autoLoad') as $file) {
        load_file($file);
    }

    // ����ָ���� session �����ṩ����
    if (get_app_inf('sessionProvider')) {
        load_file(get_app_inf('sessionProvider'));
    }
    // �Զ����� session �Ự
    if (get_app_inf('autoSessionStart')) {
        session_start();
    }

    // ���� I18N ��صĳ���
    if (get_app_inf('charsetConstant')) {
        define('RESPONSE_CHARSET', get_app_inf('responseCharset'));
        define('DATABASE_CHARSET', get_app_inf('databaseCharset'));
    }

    // ����Ƿ����ö�����֧��
    if (get_app_inf('multiLangaugeSupport')) {
        load_class(get_app_inf('languageSupportProvider'));
    }
    if (!function_exists('_T')) {
        // ���û��ָ��������֧�֣��Ͷ���һ���յ� _T() ����
        eval('function _T($key) { return $key; }');
    }
    if (!function_exists('load_language')) {
        eval('function load_language($dictname, $langauge = null) { return false; }');
    }

    // �Զ��������ͷ��Ϣ
    if (get_app_inf('autoResponseHeader')) {
        header('Content-Type: text/html; charset=' . get_app_inf('responseCharset'));
    }
}

// }}}

/**
 * FLEA Ӧ�ó������
 */
function run() {
    // ׼�����л���
    __FLEA_PREPARE();

    // �����������ת�����󵽿�����
    $dispatcher =& get_singleton(get_app_inf('dispatcher'));
    $dispatcher->dispatching($_GET);
}
