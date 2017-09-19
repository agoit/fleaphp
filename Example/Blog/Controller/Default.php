<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 FleaPHP 项目的一部分
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 Controller_Default 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Default.php 645 2006-12-19 13:58:55Z dualface $
 */

/**
 * Controller_Default 类是 Blog 示例的默认控制器
 *
 * @package Example
 * @subpackage Blog
 * @author 廖宇雷 dualface@gmail.com
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
     * 构造函数
     *
     * @return Controller_Default
     */
    function Controller_Default() {
        $this->_modelPosts =& get_singleton('Model_Posts');
        $this->_modelTags =& get_singleton('Model_Tags');
    }

    /**
     * 显示所有日志
     */
    function actionIndex() {
        /**
         * 读取所有 Tags
         */
        $tags = $this->_modelTags->findAll(null, 'label ASC');
        /**
         * 读取所有日志
         */
		$link =& $this->_modelPosts->getLinkByName('comments');
		$link->enabled = false;
        $posts = $this->_modelPosts->findAll(null, 'created DESC');

        /**
         * 将视图（模版）文件和程序的入口文件（index.php）放在同一个目录中，
         * 然后在 Action 方法里面直接 include 视图（模版）文件，可以很方便的
         * 将 Action 方法中的变量传递到视图。
         */
        include(APP_DIR . '/tpl-index.php');
    }

    /**
     * 根据用户提交的数据，创建新日志条目
     */
    function actionCreate() {
        /**
         * 创建新记录就这么简单？
         *
         * 是的，因为对 tags 进行处理的代码，我们封装在 Model_Posts 类中。
         *
         * 在 MVC 模式里面，控制器不应该包含任何“业务逻辑”代码。因此像
         * 处理 tags 这样的工作，需要交给模型（Model）去做。
         */
        $this->_modelPosts->create($_POST);

        /**
         * 添加完成，重定向浏览器到首页
         */
        redirect($this->_url());
    }

    /**
     * 显示修改日志的表单
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
     * 更新日志
     */
    function actionUpdate() {
        /**
         * 和创建记录操作一样，更新操作也封装在 Model_Posts 类中
         */
        $this->_modelPosts->update($_POST);
        redirect($this->_url());
    }

    /**
     * 删除日志
     */
    function actionRemove() {
        $this->_modelPosts->removeByPkv((int)$_GET['post_id']);
        redirect($this->_url());
    }

    /**
     * 查看日志及评论
     */
    function actionView() {
        /**
         * FLEA_Db_TableDataGateway::createLink() 可以动态添加一个关联
         *
         * 有关 createLink() 的详细信息，请参考文档。
         */
        $link = array(
            'tableClass' => 'Model_Comments',
            'mappingName' => 'comments',
        );
        /**
         * 为 Model_Posts 添加的这个关联，可以载入日志的评论信息
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
     * 添加日志评论
     */
    function actionCreateComment() {
        $modelComments =& get_singleton('Model_Comments');
        $modelComments->create($_POST);
        $this->_modelPosts->incrField($_POST['post_id'], 'comments_count');
        redirect($this->_url('view', array('post_id' => $_POST['post_id'])));
    }

    /**
     * 检索指定标签的所有日志
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
