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
 * Smarty ��ʾ������� FleaPHP Ӧ�ó�����ʹ�� Smarty ģ������
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Smarty
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

define('APP_DIR', dirname(__FILE__));
require('../../FLEA/FLEA.php');

/**
 * Ҫʹ�� Smarty������������׼������
 *
 * 1������Ӧ�ó���� view ѡ��Ϊ FLEA_View_Smarty��
 * 2������Ӧ�ó���� viewConfig ѡ��Ϊ���飬�����б������
 *    smartyDir ѡ�ָʾ Smarty ģ������Դ��������Ŀ¼��
 *
 * �����Ҫ�ڹ��� FLEA_View_Smarty ʱ�ͳ�ʼ�� Smarty ģ����������ã�
 * ֱ�ӷ����� viewConfig ѡ�������м��ɡ�
 */
$appInf = array(
    'view' => 'FLEA_View_Smarty',
    'viewConfig' => array(
        'smartyDir'         => APP_DIR . '/Smarty',
        'template_dir'      => APP_DIR,
        'compile_dir'       => APP_DIR . '/templates_c',
        'left_delimiter'    => '{{',
        'right_delimiter'   => '}}',
    ),
);

register_app_inf($appInf);
import(dirname(__FILE__));
run();
