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
 * ���� ___magic_quotes_filter ����
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: MagicQuotes.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * ���� magic_quotes ���ý�ת���ַ�ȥ��
 *
 * �ú����ɿ���Զ����ã�Ӧ�ó�����Ҫ���øú�����
 */
function ___magic_quotes_filter() {
    if (!get_magic_quotes_gpc()) { return; }
    $in = array(& $_GET, & $_POST, & $_COOKIE, & $_REQUEST);
    while (list($k,$v) = each($in)) {
    	foreach ($v as $key => $val) {
    		if (!is_array($val)) {
    			$in[$k][$key] = stripslashes($val);
    			continue;
    		}
    		$in[] =& $in[$k][$key];
    	}
    }
    unset($in);
}

/**
 * ���ù�����
 */
if (defined('FLEA_VERSION')) {
    log_message('Execute filter MagicQuotes', 'debug');
    ___magic_quotes_filter();
}
