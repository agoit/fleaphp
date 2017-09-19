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
 * ���� ___uri_filter ����
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: Uri.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * ����Ӧ�ó������� 'urlMode' ���� $_GET ����
 *
 * �ú����ɿ���Զ����ã�Ӧ�ó�����Ҫ���øú�����
 */
function ___uri_filter() {
    // ���� PATHINFO
    if (!isset($_SERVER['PATH_INFO'])) { return; }
    $_GET = array();
    $parts = explode('/', substr($_SERVER['PATH_INFO'], 1));
    $_GET[get_app_inf('controllerAccessor')] = isset($parts[0]) ? $parts[0] : '';
    $_GET[get_app_inf('actionAccessor')] = isset($parts[1]) ? $parts[1] : '';

    for ($i = 2; $i < count($parts); $i += 2) {
        if (trim($parts[$i]) && isset($parts[$i + 1])) {
            $_GET[$parts[$i]] = $parts[$i + 1];
        }
    }
    // �� $_GET �ϲ��� $_REQUEST����ʱ��Ҫʹ�� $_REQUEST ͳһ���� url �е� id=? �����Ĳ���
    $_REQUEST = array_merge($_REQUEST, $_GET);
}

/**
 * ���ù�����
 */
if (defined('FLEA_VERSION')) {
    log_message('Execute filter Uri', 'debug');
    ___uri_filter();
}
