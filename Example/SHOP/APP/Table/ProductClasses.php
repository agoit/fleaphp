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
 * 定义 Table_ProductClasses 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductClasses.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Table_Nodes');
// }}}

/**
 * Table_ProductClasses 提供商品分类信息的数据库访问服务
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Table_ProductClasses extends Table_Nodes
{
    /**
     * 数据表名称
     *
     * @var string
     */
    var $tableName = 'product_classes';

    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey = 'class_id';
}
