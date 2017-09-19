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
 * �������п������ķ��ʿ��Ʊ�
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: DefaultACT.php 682 2007-01-05 16:25:15Z dualface $
 */

return array(
    /**
     * BoLogin ������
     */
    'BoLogin' => array(
        'allow' => RBAC_EVERYONE,
    ),

    /**
     * BoBase ������
     */
    'BoBase' => array(
       'deny' => RBAC_EVERYONE,
    ),

    /**
     * BoDashboard ������
     */
    'BoDashboard' => array(
        'allow' => RBAC_HAS_ROLE,

        'phpinfo' => array(
            'allow' => 'SYSTEM_ADMIN',
        ),
    ),

    /**
     * BoProductClasses ������
     */
    'BoProductClasses' => array(
        'allow' => 'SYSTEM_ADMIN',
    ),

    /**
     * BoProducts ������
     */
    'BoProducts' => array(
        'allow' => 'SYSTEM_ADMIN',
    ),

    /**
     * BoPreference ������
     */
    'BoPreference' => array(
        'allow' => 'SYSTEM_ADMIN',
    ),
);
