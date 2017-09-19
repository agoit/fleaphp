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
 * 定义 Model_SysRoles 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: SysRoles.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Com_RBAC_RolesManager');
// }}}

/**
 * Model_SysRoles 封装了对系统角色信息的操作，同时还辅助 Model_SysUsers 取出用户的角色信息
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Model_SysRoles extends FLEA_Com_RBAC_RolesManager
{
    /**
     * 数据表名称
     *
     * @var string
     */
    var $tableName = 'sysroles';

    /**
     * 主键字段名
     *
     * @var unknown_type
     */
    var $primaryKey = 'role_id';
}
