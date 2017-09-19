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
 * 定义 Tags 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Tags.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
/**
 * FleaPHP 不会默认载入 FLEA_Db_TableDataGateway 类的定义，
 * 因此需要明确载入。
 */
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Tags 类封装了对数据表 blog_posts 的操作
 *
 * @package Example
 * @subpackage Blog
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Model_Tags extends FLEA_Db_TableDataGateway
{
    /**
     * 数据表名称
     *
     * @var string
     */
    var $tableName = 'blog_tags';

    /**
     * 该数据表的主键字段名
     *
     * @var string
     */
    var $primaryKey = 'tag_id';
}
