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
 * ���� Tags ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Tags.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
/**
 * FleaPHP ����Ĭ������ FLEA_Db_TableDataGateway ��Ķ��壬
 * �����Ҫ��ȷ���롣
 */
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Tags ���װ�˶����ݱ� blog_posts �Ĳ���
 *
 * @package Example
 * @subpackage Blog
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_Tags extends FLEA_Db_TableDataGateway
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'blog_tags';

    /**
     * �����ݱ�������ֶ���
     *
     * @var string
     */
    var $primaryKey = 'tag_id';
}
