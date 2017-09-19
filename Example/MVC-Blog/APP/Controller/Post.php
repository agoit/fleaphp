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
 * @version $Id: Post.php 684 2007-01-06 20:25:08Z dualface $
 */

/**
 * ���� Post ������
 *
 * Post �������ṩ�� Blog ���б��鿴��ɾ������ӹ��ܡ�
 */
class Controller_Post extends FLEA_Controller_Action
{
    /**
     * Model_Posts ��ʵ��
     *
     * Model_Posts �����ṩ�� Blog ���ݵĲ�ѯ����ӡ�ɾ���͸��µȲ�����
     *
     * @var Model_Posts
     */
    var $_modelPosts;

    /**
     * ���캯��
     *
     * @return Controller_Post
     */
    function Controller_Post()
    {
        /**
         * get_singleton() ���Զ�����ָ����Ķ����ļ������ҷ��ظ����Ψһһ��ʵ��
         */
        $this->_modelPosts =& get_singleton('Model_Posts');
    }

    /**
     * �г�����
     */
    function actionIndex()
    {
        /**
         * findAll() ������ Model_Posts �ĸ����һ��������������Ϣ��ο�
         * http://www.fleaphp.org/downloads/apidoc/DB/FLEA_Db_TableDataGateway.html
         */
        $posts = $this->_modelPosts->findAll();

        /**
         * ֱ�Ӱ���ģ���ļ���������������ģ���ļ���ֱ��ʹ�� actionIndex() �����ж���ı��������� $posts
         */
        include('APP/View/PostIndex.php');
    }

    /**
     * ��ʾ������ӵı�
     */
    function actionAdd()
    {
        include('APP/View/PostAdd.php');
    }

    /**
     * ������ӵ�����
     */
    function actionSave()
    {
        /**
         * ֻҪ�� FLEA_Db_TableDataGateway �ṩ������ʽ�Ĳ�����
         * FleaPHP �ͻ��Զ������ݽ���ת�壬ȷ��������� SQL ע��©����
         *
         * save() ������ Model_Posts �ĸ����һ��������������Ϣ��ο�
         * http://www.fleaphp.org/downloads/apidoc/DB/FLEA_Db_TableDataGateway.html
         */
        $data = array(
            'title' => $_POST['title'],
            'body' => $_POST['content']
        );
        $this->_modelPosts->save($data);

        /**
         * ������Ӻ��� redirect() �ض���������������б�
         *
         * ��Ҫ�ض���� url ��ʹ�� url() �������ɡ�
         *
         * �� FleaPHP �У������漰�����ÿ������� url ��Ӧ���� url() �������ɣ�
         * ������д���ڳ����С��������Ի����õ�����ԡ�
         */
        redirect(url('Post', 'Index'));
    }

    /**
     * �鿴ָ������
     */
    function actionView()
    {
        /**
         * ���� $_GET['id'] ��ȡָ��������
         */
        $id = (int)$_GET['id'];
        $post = $this->_modelPosts->find($id);

        include('APP/View/PostView.php');
    }

    /**
     * ɾ��ָ������
     */
    function actionDelete()
    {
        /**
         * ���� $_GET['id'] ɾ��ָ��������
         */
        $id = (int)$_GET['id'];
        /**
         * ��������ͨ�� $_GET['id'] ���ݵ��������������ݿ��¼�������ֶ�ֵ��
         * ��������ʹ�� FLEA_Db_TableDataGateway �� removeByPkv() ������ɾ�����ӡ�
         */
        $post = $this->_modelPosts->removeByPkv($id);

        redirect(url('Post', 'Index'));
    }
}
