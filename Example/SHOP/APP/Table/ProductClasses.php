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
 * ���� Table_ProductClasses ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductClasses.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Table_Nodes');
// }}}

/**
 * Table_ProductClasses �ṩ��Ʒ������Ϣ�����ݿ���ʷ���
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Table_ProductClasses extends Table_Nodes
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'product_classes';

    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey = 'class_id';
}
