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
 * ���� Comments ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Blog
 * @version $Id: Comments.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Comments ���װ�˶����ݱ� blog_comments �Ĳ���
 *
 * @package Example
 * @subpackage Blog
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_Comments extends FLEA_Db_TableDataGateway
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'blog_comments';

    /**
     * �����ݱ�������ֶ���
     *
     * @var string
     */
    var $primaryKey = 'comment_id';
}
