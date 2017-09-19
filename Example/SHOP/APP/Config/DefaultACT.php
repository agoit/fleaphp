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
 * 定义所有控制器的访问控制表
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: DefaultACT.php 682 2007-01-05 16:25:15Z dualface $
 */

return array(
    /**
     * BoLogin 控制器
     */
    'BoLogin' => array(
        'allow' => RBAC_EVERYONE,
    ),

    /**
     * BoBase 控制器
     */
    'BoBase' => array(
       'deny' => RBAC_EVERYONE,
    ),

    /**
     * BoDashboard 控制器
     */
    'BoDashboard' => array(
        'allow' => RBAC_HAS_ROLE,

        'phpinfo' => array(
            'allow' => 'SYSTEM_ADMIN',
        ),
    ),

    /**
     * BoProductClasses 控制器
     */
    'BoProductClasses' => array(
        'allow' => 'SYSTEM_ADMIN',
    ),

    /**
     * BoProducts 控制器
     */
    'BoProducts' => array(
        'allow' => 'SYSTEM_ADMIN',
    ),

    /**
     * BoPreference 控制器
     */
    'BoPreference' => array(
        'allow' => 'SYSTEM_ADMIN',
    ),
);
