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
 * MVC-Blog ��ʾ��һ��ʹ�� FleaPHP �ṩ�� MVC ģʽʵ�ֵļ� Blog
 *
 * ��ʾ�����������ѡ�С·�����ף����� CakePHP ͬ��ʾ������ʵ�֡�
 * С·ͬʱ�� PHPChina��http://www.phpchina.com/���Ϸ����˸�ʾ������� Zend Framework �汾��
 *
 * ZF �汾��ַ��http://www.phpchina.com/bbs/thread-5820-1-1.html
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ���ѡ�С·��
 * @package Example
 * @subpackage MVC-Blog
 * @version $Id: Posts.php 684 2007-01-06 20:25:08Z dualface $
 */

// ���������Ķ���
load_class('FLEA_Db_TableDataGateway');

/**
 * Model_Posts ���� FLEA_Db_TableDataGateway ���һ�����ࡣ
 *
 * ͨ��ָ�� $tableName �� $primaryKey ���ԣ����ܹ��� Model_Posts �����ݱ����
 * CRUD����������ȡ�����¡�ɾ�����������������д���ݿ�������룬�ṩ�˿���Ч�ʡ�
 */
class Model_Posts extends FLEA_Db_TableDataGateway {
    /**
     * $tableName ��������ָ�� Model_Posts �ǲ�����һ�����ݱ�
     *
     * @var string
     */
    var $tableName = 'mvc_posts';
    // ָ�������ֶ���

    /**
     * $primaryKey ����ָ��Ҫ���������ݱ�������ֶ���
     *
     * @var string
     */
    var $primaryKey = 'id';
}

/*
mvc_posts ���ݱ�Ľṹ���壺

CREATE TABLE `mvc_posts` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` DATETIME default NULL,
  `updated` DATETIME default NULL,
  PRIMARY KEY  (`id`)
);

*/
