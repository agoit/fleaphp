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
 * 定义 FLEA_Com_RBAC_RolesManager 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package RBAC
 * @version $Id: RolesManager.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * FLEA_Com_RBAC_RolesManager 派生自 FLEA_Db_TableDataGateway，
 * 用于访问保存角色信息的数据表
 *
 * 如果数据表的名字不同，应该从 FLEA_Com_RBAC_RolesManager
 * 派生类并使用自定义的数据表名字、主键字段名等。
 *
 * @package RBAC
 */
class FLEA_Com_RBAC_RolesManager extends FLEA_Db_TableDataGateway
{
    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey = 'role_id';

    /**
     * 数据表名字
     *
     * @var string
     */
    var $tableName = 'roles';

    /**
     * 角色名字段
     *
     * @var string
     */
    var $rolesNameField = 'rolename';

    function FLEA_Com_RBAC_RolesManager() {
        log_message('Construction FLEA_Com_RBAC_RolesManager', 'debug');
        parent::FLEA_Db_TableDataGateway();
    }
}
