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
 * ���� Model_Posts ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Posts.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
/**
 * FleaPHP ����Ĭ������ FLEA_Db_TableDataGateway ��Ķ��壬
 * �����Ҫ��ȷ���롣
 */
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Model_Posts ���װ�˶����ݱ� blog_posts �Ĳ���
 *
 * @package Example
 * @subpackage Blog
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_Posts extends FLEA_Db_TableDataGateway
{
    /**
     * ���ݱ�����
     *
     * ����ÿһ���� FLEA_Db_TableDataGateway �������࣬
     * tableName �� primaryKey ��Ա�������Ǳ��붨��ġ�
     *
     * @var string
     */
    var $tableName = 'blog_posts';

    /**
     * �����ݱ�������ֶ���
     *
     * @var string
     */
    var $primaryKey = 'post_id';

    /**
     * �����Զ������MANY_TO_MANY��
     *
     * ���ڶ�Զ��������ϸ��Ϣ����ο��ĵ��� FLEA_Db_TableDataGateway �е����ע�͡�
     *
     * @var array
     */
    var $manyToMany = array(
        'tableClass' => 'Model_Tags',
        'mappingName' => 'tags',
        'joinTable' => 'blog_posts_tags',
    );

	/**
	 * ����һ�Զ������HAS_MANY��
	 *
	 * @var array
	 */
	var $hasMany = array(
		'tableClass' => 'Model_Comments',
		'mappingName' => 'comments',
	);

    /**
     * ��������־��Ŀ
     *
     * ���Ǹ��� FLEA_Db_TableDataGateway �е� create() ������
     * ��Ϊ�����ڴ�����־��Ŀʱ����ɶ� tags �Ĵ�������
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
     * ������־��Ŀ
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
     * ��ɶ���־��Ŀ�������� tags �Ĵ���
     *
     * @param array $row
     */
    function _processTags(& $row) {
        // �������ݿ����е����� tags
        $modelTags =& get_singleton('Model_Tags');
        /* @var $modelTags Model_Tags */
        $rowset = $modelTags->findAll(null);
        $existsTags = array_to_hashmap($rowset, 'label', 'tag_id');

        // �����û������ tags
        $labels = explode(',', $row['tags']);
        $tagsIdList = array();
        foreach ($labels as $label) {
            $label = strtolower(trim($label));
            if ($label == '') { continue; }
            if (isset($existsTags[$label])) {
                // ����־�Ǽǵ����� tag
                $tagsIdList[] = $existsTags[$label];
            } else {
                // ������ tag�����Ǽ���־
                $tag = array('label' => $label);
                $tagsIdList[] = $modelTags->create($tag);
            }
        }

        $row['tags'] = $tagsIdList;
    }
}
