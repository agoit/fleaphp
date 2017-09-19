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
 * ���� Table_Products ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: Products.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Table_Products �ṩ��Ʒ��Ϣ�����ݿ���ʷ���
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Table_Products extends FLEA_Db_TableDataGateway
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'products';

    /**
     * �����ֶ�
     *
     * @var string
     */
    var $primaryKey = 'product_id';

    /**
     * ��Ʒ������Ʒ���
     *
     * @var array
     */
    var $manyToMany = array(
        'tableClass' => 'Table_ProductClasses',
        'mappingName' => 'classes',
        'joinTable' => 'products_to_classes',
    );

    /**
     * ��Ʒ�ж��ţ�0-n����Ƭ
     *
     * @var array
     */
    var $hasMany = array(
        'tableClass' => 'Table_ProductPhotos',
        'mappingName' => 'photos',
    );
}
