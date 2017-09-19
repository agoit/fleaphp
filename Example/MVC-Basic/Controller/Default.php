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
 * ���� MVC-Basic ʾ���Ŀ�����
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage MVC-Basic
 * @version $Id: Default.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Controller_Default ������
 *
 * �������� MVC ģʽ������ľ������ñȽϸ��ӡ���Ϊ MVC ģʽ����Ҳ�кܶ���ʵ�ַ�ʽ��
 *
 * �� FleaPHP ʵ�ֵ� MVC ģʽ�У���������Controller��ͨ�����մ�����������������ݣ�
 * Ȼ�����ģ�ͣ�Model�����������ݽ��д�������ô�������
 *
 * ��󽫽�����ݸ���ͼ��View������ͼ�Ḻ�𽫴�����ת��Ϊ HTML �ĵ���ʵ���Ͽ���
 * ����κ����ݣ����ظ��������
 *
 * ��Ȼ�� FleaPHP �У�����Ҫ������������ FLEA_Controller_Action �༴�ɡ�
 * ������ FLEA_Controller_Action �ṩһЩ�򻯱�̵ķ�������˴���������������Լ���
 * ��������һ���Ƽ���������
 *
 * @package Example
 * @subpackage MVC-Basic
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_Default extends FLEA_Controller_Action
{
    /**
     * Ĭ�Ͽ���������
     *
     * ��Ȼ FleaPHP Ӧ�ó���Ĭ�����õĿ�����������Ϊ index��������ͬʱ������
     * ������������ǰ׺��Ӧ�ó������� actionMethodPrefix ѡ�Ϊ action��
     * ��˿�����������ʵ�ʺ������ǡ�ǰ׺+����������������
     *
     * ���Դ˴��ĺ�����Ϊ actionIndex()��
     */
    function actionIndex() {
        /**
         * �� get_singleton() ��ȡ Model �Ķ���ʵ����
         *
         * �ú�������ָ�����Ψһһ��ʵ�������� get_singleton() �᳢���Զ�������
         * �����ļ�������ʹ�÷ǳ����㡣
         */
        $modelSayName =& get_singleton('Model_SayName');
        /* @var $modelSayName Model_SayName */
        /**
         * �������п���ȥ��ֵ�ע�ͣ��ǰ������� Zend Development Environment ��
         * Eclipse PHP IDE �����ı༭��ʶ�� $modelSayName ��������ȷ���͡�
         */

        /**
         * ���� Model ��ȡ����
         */
        $name = $modelSayName->say();

        /**
         * �� FleaPHP��ͨ������Ҫֱ�ӻ�ȡ��ͼ����
         *
         * ���ǵ��� FLEA_Controller_Action::_executeView() ������ֱ�������ͼ��
         *
         * _executeView() �����ĵ�һ����������ͼ�����֣������ʱ������ͼ���ļ������������ Smarty
         * ��˵������ģ���ļ��������ڶ���������Ҫ���ݸ���ͼ�ı�����������һ�����飩��
         */
        $viewData = array(
            'name' => $name,
        );
        $this->_executeView('View/DisplayName.php', $viewData);
    }
}
