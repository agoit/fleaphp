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
 * 定义 Model_Posts 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Posts.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
/**
 * FleaPHP 不会默认载入 FLEA_Db_TableDataGateway 类的定义，
 * 因此需要明确载入。
 */
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Model_Posts 类封装了对数据表 blog_posts 的操作
 *
 * @package Example
 * @subpackage Blog
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Model_Posts extends FLEA_Db_TableDataGateway
{
    /**
     * 数据表名称
     *
     * 对于每一个从 FLEA_Db_TableDataGateway 派生的类，
     * tableName 和 primaryKey 成员变量都是必须定义的。
     *
     * @var string
     */
    var $tableName = 'blog_posts';

    /**
     * 该数据表的主键字段名
     *
     * @var string
     */
    var $primaryKey = 'post_id';

    /**
     * 定义多对多关联（MANY_TO_MANY）
     *
     * 关于多对多关联的详细信息，请参考文档和 FLEA_Db_TableDataGateway 中的相关注释。
     *
     * @var array
     */
    var $manyToMany = array(
        'tableClass' => 'Model_Tags',
        'mappingName' => 'tags',
        'joinTable' => 'blog_posts_tags',
    );

	/**
	 * 定义一对多关联（HAS_MANY）
	 *
	 * @var array
	 */
	var $hasMany = array(
		'tableClass' => 'Model_Comments',
		'mappingName' => 'comments',
	);

    /**
     * 创建新日志条目
     *
     * 我们覆盖 FLEA_Db_TableDataGateway 中的 create() 方法，
     * 是为了能在创建日志条目时，完成对 tags 的处理工作。
     *
     * @param array $row
     *
     * @return boolean
     */
    function create(& $row) {
        $this->_processTags($row);
        return parent::create($row);
    }

    /**
     * 更新日志条目
     *
     * @param array $row
     *
     * @return boolean
     */
    function update(& $row) {
        $this->_processTags($row);
        return parent::update($row);
    }

    /**
     * 完成对日志条目所关联的 tags 的处理
     *
     * @param array $row
     */
    function _processTags(& $row) {
        // 读出数据库现有的所有 tags
        $modelTags =& get_singleton('Model_Tags');
        /* @var $modelTags Model_Tags */
        $rowset = $modelTags->findAll(null);
        $existsTags = array_to_hashmap($rowset, 'label', 'tag_id');

        // 处理用户输入的 tags
        $labels = explode(',', $row['tags']);
        $tagsIdList = array();
        foreach ($labels as $label) {
            $label = strtolower(trim($label));
            if ($label == '') { continue; }
            if (isset($existsTags[$label])) {
                // 将日志登记到现有 tag
                $tagsIdList[] = $existsTags[$label];
            } else {
                // 创建新 tag，并登记日志
                $tag = array('label' => $label);
                $tagsIdList[] = $modelTags->create($tag);
            }
        }

        $row['tags'] = $tagsIdList;
    }
}
