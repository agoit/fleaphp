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
 * ���� Model_SysRoles ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: SysRoles.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Com_RBAC_RolesManager');
// }}}

/**
 * Model_SysRoles ��װ�˶�ϵͳ��ɫ��Ϣ�Ĳ�����ͬʱ������ Model_SysUsers ȡ���û��Ľ�ɫ��Ϣ
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_SysRoles extends FLEA_Com_RBAC_RolesManager
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'sysroles';

    /**
     * �����ֶ���
     *
     * @var unknown_type
     */
    var $primaryKey = 'role_id';
}
