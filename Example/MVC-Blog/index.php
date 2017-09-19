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
 * MVC-Blog ��ʾ��һ��ʹ�� FleaPHP �ṩ�� MVC ģʽʵ�ֵļ� Blog
 *
 * ��ʾ�����������ѡ�С·�����ף����� CakePHP ͬ��ʾ������ʵ�֡�
 * С·ͬʱ�� PHPChina��http://www.phpchina.com/���Ϸ����˸�ʾ������� Zend Framework �汾��
 *
 * ZF �汾��ַ��http://www.phpchina.com/bbs/thread-5820-1-1.html
 *
 * ����Ϊ�˳������ FleaPHP �ļ�࣬���ʾ������� ZF ���ͬ�ȳ�����һ����Ҫ�Ĳ�֮ͬ����
 *
 * FleaPHP ���ʾ������ֻ������������������Ĭ�ϵĿ���������ʵ�ʹ������������ض���������� Post ��������
 * Blog ���б��鿴��ɾ������ӵȲ��������� Post ��������ɡ�
 * ���� ZF ���ʾ�������У���Щ�����ɶ����������ɡ�
 *
 * ͨ�����ʾ�����򣬿����߿����˽����ʹ�� FleaPHP �� MVC ģʽ��
 * ͬʱ��ͨ����ͬ�ȹ��ܵ� ZF ��ʾ������Ƚϣ����ܷ��� FleaPHP ���ʾ�����򲻵�������٣�
 * ���ҽṹ�������׶����ر����漰�� Blog �ĳ������ݿ����ֻ��Ҫһ���д��뼴����ɡ�
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ���ѡ�С·��
 * @package Example
 * @subpackage MVC-Blog
 * @version $Id: index.php 684 2007-01-06 20:25:08Z dualface $
 */

/**
 * �����������ݿ������ļ������ʧ������ʾ����ҳ��
 */
$configFilename = '../_Shared/DSN.php';
if (!is_readable($configFilename)) {
    header('Location: ../../Install/setup-required.php');
}

/**
 * ��������fleaphp�Ŀ��ļ�,������һЩ�����Ĵ���.
 * ��������StdLibs.php,�Ա��ṩ���õ�fleaphp����.
 */
require('../../FLEA/FLEA.php');

/**
 * ָ��ʵ�ʴ����·��,Fleaphp֮�������Զ��ҵ�controllerĿ¼,modelĿ¼�µ���,ȫ������ָ��·��
 */
import(dirname(__FILE__) . '/APP');

/**
 * �Ҳ��������Զ�����,����:FLEA_Db_TableDataGateway�����.
 * ע��,�˷�����������php4,ֻ������PHP5
 */
function __autoload($className) {
    load_class($className);
}

/**
 * ָ�����ݿ��������ã�TableDataGateway ���Զ�ȡ�� dbDSN �������������ݿ⡣
 * register_app_inf() ���ÿ�����ָ����Ӧ�ó������ø��� FleaPHP �ṩ��Ĭ�����á�
 * �����߿���ʹ�� get_app_inf() ȡ������Ӧ�ó������á�
 */
register_app_inf($configFilename);

/**
 * ���� url ģʽΪ URL_PATHINFO
 *
 * Ĭ�� url ģʽ����ʾЧ��Ϊ http://localhost/index.php?controller=Post&action=Index
 * URL_PATHINFO ����ʾЧ��Ϊ http://localhost/index.php/Post/Index/
 */
set_app_inf('urlMode', URL_PATHINFO);

/**
 * run()ֻ����������:
 *
 * һ.��׼�����л���.
 * ��.����url��ַʵ����ָ����controller��,����ָ����action.
 */
run();
