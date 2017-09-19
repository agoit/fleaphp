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
 * @version $Id: Posts.php 684 2007-01-06 20:25:08Z dualface $
 */

// 载入基础类的定义
load_class('FLEA_Db_TableDataGateway');

/**
 * Model_Posts 类是 FLEA_Db_TableDataGateway 类的一个子类。
 *
 * 通过指定 $tableName 和 $primaryKey 属性，就能够用 Model_Posts 对数据表进行
 * CRUD（创建、读取、更新、删除）操作，而无需编写数据库操作代码，提供了开发效率。
 */
class Model_Posts extends FLEA_Db_TableDataGateway {
    /**
     * $tableName 属性用于指定 Model_Posts 是操作哪一个数据表
     *
     * @var string
     */
    var $tableName = 'mvc_posts';
    // 指定主键字段名

    /**
     * $primaryKey 属性指定要操作的数据表的主键字段名
     *
     * @var string
     */
    var $primaryKey = 'id';
}

/*
mvc_posts 数据表的结构定义：

CREATE TABLE `mvc_posts` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` DATETIME default NULL,
  `updated` DATETIME default NULL,
  PRIMARY KEY  (`id`)
);

*/
