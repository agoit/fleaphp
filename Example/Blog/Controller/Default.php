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
 * ���� Controller_Default ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Default.php 645 2006-12-19 13:58:55Z dualface $
 */

/**
 * Controller_Default ���� Blog ʾ����Ĭ�Ͽ�����
 *
 * @package Example
 * @subpackage Blog
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_Default extends FLEA_Controller_Action
{
    /**
     * @var Model_Posts
     */
    var $_modelPosts;

    /**
     * @var Model_Tags
     */
    var $_modelTags;

    /**
     * ���캯��
     *
     * @return Controller_Default
     */
    function Controller_Default() {
        $this->_modelPosts =& get_singleton('Model_Posts');
        $this->_modelTags =& get_singleton('Model_Tags');
    }

    /**
     * ��ʾ������־
     */
    function actionIndex() {
        /**
         * ��ȡ���� Tags
         */
        $tags = $this->_modelTags->findAll(null, 'label ASC');
        /**
         * ��ȡ������־
         */
		$link =& $this->_modelPosts->getLinkByName('comments');
		$link->enabled = false;
        $posts = $this->_modelPosts->findAll(null, 'created DESC');

        /**
         * ����ͼ��ģ�棩�ļ��ͳ��������ļ���index.php������ͬһ��Ŀ¼�У�
         * Ȼ���� Action ��������ֱ�� include ��ͼ��ģ�棩�ļ������Ժܷ����
         * �� Action �����еı������ݵ���ͼ��
         */
        include(APP_DIR . '/tpl-index.php');
    }

    /**
     * �����û��ύ�����ݣ���������־��Ŀ
     */
    function actionCreate() {
        /**
         * �����¼�¼����ô�򵥣�
         *
         * �ǵģ���Ϊ�� tags ���д���Ĵ��룬���Ƿ�װ�� Model_Posts ���С�
         *
         * �� MVC ģʽ���棬��������Ӧ�ð����κΡ�ҵ���߼������롣�����
         * ���� tags �����Ĺ�������Ҫ����ģ�ͣ�Model��ȥ����
         */
        $this->_modelPosts->create($_POST);

        /**
         * �����ɣ��ض������������ҳ
         */
        redirect($this->_url());
    }

    /**
     * ��ʾ�޸���־�ı�
     */
    function actionEdit() {
        $post = $this->_modelPosts->find((int)$_GET['post_id']);
        if (!$post) {
            redirect($this->_url());
        }
        $tags = implode(', ', array_col_values($post['tags'], 'label'));

        include(APP_DIR . '/tpl-edit.php');
    }

    /**
     * ������־
     */
    function actionUpdate() {
        /**
         * �ʹ�����¼����һ�������²���Ҳ��װ�� Model_Posts ����
         */
        $this->_modelPosts->update($_POST);
        redirect($this->_url());
    }

    /**
     * ɾ����־
     */
    function actionRemove() {
        $this->_modelPosts->removeByPkv((int)$_GET['post_id']);
        redirect($this->_url());
    }

    /**
     * �鿴��־������
     */
    function actionView() {
        /**
         * FLEA_Db_TableDataGateway::createLink() ���Զ�̬���һ������
         *
         * �й� createLink() ����ϸ��Ϣ����ο��ĵ���
         */
        $link = array(
            'tableClass' => 'Model_Comments',
            'mappingName' => 'comments',
        );
        /**
         * Ϊ Model_Posts ��ӵ��������������������־��������Ϣ
         */
        $this->_modelPosts->createLink($link, HAS_MANY);

        $post = $this->_modelPosts->find((int)$_GET['post_id']);
        if (!$post) {
            redirect($this->_url());
        }
        $tags = implode(' ', array_col_values($post['tags'], 'label'));

        include(APP_DIR . '/tpl-view.php');
    }

    /**
     * �����־����
     */
    function actionCreateComment() {
        $modelComments =& get_singleton('Model_Comments');
        $modelComments->create($_POST);
        $this->_modelPosts->incrField($_POST['post_id'], 'comments_count');
        redirect($this->_url('view', array('post_id' => $_POST['post_id'])));
    }

    /**
     * ����ָ����ǩ��������־
     */
    function actionTag() {
        $tags = $this->_modelTags->findAll(null, 'label ASC');
        $link = array(
            'tableClass' => 'Model_Posts',
            'mappingName' => 'posts',
            'joinTable' => 'blog_posts_tags',
            'sort' => 'created DESC',
        );
        $this->_modelTags->createLink($link, MANY_TO_MANY);
        $tag = $this->_modelTags->find((int)$_GET['tag_id']);
        $posts = $tag['posts'];
        include(APP_DIR . '/tpl-posts-by-tag.php');
    }
}
