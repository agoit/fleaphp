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
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ���ѡ�С·��
 * @package Example
 * @subpackage MVC-Blog
 * @version $Id: Default.php 684 2007-01-06 20:25:08Z dualface $
 */

/**
 * ����Ӧ�ó����Ĭ�Ͽ�����
 *
 * FleaPHP Ĭ�ϵĿ���������Ϊ Default��
 *
 * ���� FleaPHP Ӧ�ó������� controllerClassPrefix Ϊ 'Controller_'��
 * ���Ĭ�Ͽ������������ƾ��� 'Controller_Default'��
 *
 * ���Ĭ�Ͽ�����û���������ܣ��������ض���������� Post ��������
 */
class Controller_Default extends FLEA_Controller_Action
{
    /**
     * ���캯��
     *
     * @return Controller_Default
     */
    function Controller_Default()
    {
        redirect(url('Post'));
    }
}
