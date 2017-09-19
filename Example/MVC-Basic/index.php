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
 * MVC-Basic ��ʾ�� FleaPHP �� MVC ģʽ
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage MVC-Basic
 * @version $Id: index.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * ���� FleaPHP Ӧ�ó��򶼱������� FLEA.php �ļ�
 *
 * ���� FLEA.php �ļ�ʱ��FleaPHP ��ܵĺ��Ļ��Զ���ʼ������ʼ�����ְ�����
 *     ���������⣨FLEA/StdLibs.php��
 *     �쳣��FLEA/ExceptionPHP4/5.php��
 */
require('../../FLEA/FLEA.php');

/**
 * import ��һ���ǳ���Ҫ�ĺ���
 *
 * �ú������һ��ָ��·���� FleaPHP �ڲ����ļ�����·���б��С�
 * FleaPHP �� load_class()��get_file_path() ������ͨ���������·���б�
 * ���ҷ��� FleaPHP ����ָ�������淶���ඨ���ļ���
 */
import(dirname(__FILE__));

/**
 * run() ����ִ��Ӧ�ó���
 *
 * ����ʹ�� MVC ģʽ�� FleaPHP Ӧ�ó���run() �����Ǳ�����õġ�
 *
 * run() ����ִ��ʱ���ṹ�� $dispatcher��Ĭ��Ϊ FLEA_Dispatcher_Simple �ࣩ����
 * Ȼ����� $dispatcher ����� dispatching() ������
 *
 * dispatching() �������� URL �������ṩ�Ŀ��������ƺ� Action ����ȷ��Ҫ���õ�
 * ����������������������� run() ������ $dispatcher ����ʵ���ϳ䵱��һ����վ��
 * ��ڵ���Ա��
 *
 * �������ʾ����������� FleaPHP ��Ĭ�����ã������û���ṩ�κ� URL ����������¡�
 * �������Ϊ Controller_Default �Ŀ����������� index() ������������
 *
 * Ĭ�Ͽ�������Ĭ�Ͽ��������������־������� FleaPHP ��Ӧ�ó��������ļ��С�
 */
run();
