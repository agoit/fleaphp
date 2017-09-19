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
 * MVC-Blog 演示了一个使用 FleaPHP 提供的 MVC 模式实现的简单 Blog
 *
 * 该示例程序由网友“小路”贡献，参照 CakePHP 同等示例程序实现。
 * 小路同时在 PHPChina（http://www.phpchina.com/）上发布了该示例程序的 Zend Framework 版本。
 *
 * ZF 版本地址：http://www.phpchina.com/bbs/thread-5820-1-1.html
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 网友“小路”
 * @package Example
 * @subpackage MVC-Blog
 * @version $Id: Post.php 684 2007-01-06 20:25:08Z dualface $
 */

/**
 * 定义 Post 控制器
 *
 * Post 控制器提供了 Blog 的列表、查看、删除和添加功能。
 */
class Controller_Post extends FLEA_Controller_Action
{
    /**
     * Model_Posts 的实例
     *
     * Model_Posts 对象提供了 Blog 数据的查询、添加、删除和更新等操作。
     *
     * @var Model_Posts
     */
    var $_modelPosts;

    /**
     * 构造函数
     *
     * @return Controller_Post
     */
    function Controller_Post()
    {
        /**
         * get_singleton() 会自动载入指定类的定义文件，并且返回该类的唯一一个实例
         */
        $this->_modelPosts =& get_singleton('Model_Posts');
    }

    /**
     * 列出帖子
     */
    function actionIndex()
    {
        /**
         * findAll() 方法是 Model_Posts 的父类的一个方法，具体信息请参考
         * http://www.fleaphp.org/downloads/apidoc/DB/FLEA_Db_TableDataGateway.html
         */
        $posts = $this->_modelPosts->findAll();

        /**
         * 直接包含模版文件，可以让我们在模版文件中直接使用 actionIndex() 方法中定义的变量，例如 $posts
         */
        include('APP/View/PostIndex.php');
    }

    /**
     * 显示添加帖子的表单
     */
    function actionAdd()
    {
        include('APP/View/PostAdd.php');
    }

    /**
     * 保存添加的帖子
     */
    function actionSave()
    {
        /**
         * 只要给 FLEA_Db_TableDataGateway 提供数组形式的参数，
         * FleaPHP 就会自动对数据进行转义，确保不会存在 SQL 注入漏洞。
         *
         * save() 方法是 Model_Posts 的父类的一个方法，具体信息请参考
         * http://www.fleaphp.org/downloads/apidoc/DB/FLEA_Db_TableDataGateway.html
         */
        $data = array(
            'title' => $_POST['title'],
            'body' => $_POST['content']
        );
        $this->_modelPosts->save($data);

        /**
         * 添加帖子后，用 redirect() 重定向浏览器到帖子列表
         *
         * 而要重定向的 url 则使用 url() 函数生成。
         *
         * 在 FleaPHP 中，所有涉及到调用控制器的 url 都应该由 url() 函数生成，
         * 而不是写死在程序中。这样可以获得最好的灵活性。
         */
        redirect(url('Post', 'Index'));
    }

    /**
     * 查看指定帖子
     */
    function actionView()
    {
        /**
         * 根据 $_GET['id'] 读取指定的帖子
         */
        $id = (int)$_GET['id'];
        $post = $this->_modelPosts->find($id);

        include('APP/View/PostView.php');
    }

    /**
     * 删除指定帖子
     */
    function actionDelete()
    {
        /**
         * 根据 $_GET['id'] 删除指定的帖子
         */
        $id = (int)$_GET['id'];
        /**
         * 由于我们通过 $_GET['id'] 传递的正好是帖子数据库记录的主键字段值，
         * 所以我们使用 FLEA_Db_TableDataGateway 的 removeByPkv() 方法来删除帖子。
         */
        $post = $this->_modelPosts->removeByPkv($id);

        redirect(url('Post', 'Index'));
    }
}
