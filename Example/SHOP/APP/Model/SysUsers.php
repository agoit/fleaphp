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
 * ���� Model_SysUsers ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: SysUsers.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Com_RBAC_UsersManager');
// }}}

/**
 * Model_SysUsers ��װ�˶�ϵͳ�û���Ϣ�Ĳ�����ͬʱ������ȡ���û��Ľ�ɫ��Ϣ
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_SysUsers extends FLEA_Com_RBAC_UsersManager
{
    /**
     * �����û���Ϣ�����ݱ�����
     *
     * @var string
     */
    var $tableName = 'sysusers';

    /**
     * �����ֶ���
     *
     * @var unknown_type
     */
    var $primaryKey = 'user_id';

    /**
     * ����һ����Զ������ȷ�� Model_SysUsers �ܹ���ȡ�û��Ľ�ɫ��Ϣ
     *
     * @var array
     */
    var $manyToMany = array(
        'tableClass' => 'Model_SysRoles',
        'mappingName' => 'roles',
        'joinTable' => 'sysusers_sysroles',
    );

    /**
     * ָʾ�û���¼�У���ʲô�ֶα����û��Ľ�ɫ��Ϣ
     *
     * �����Ա������ֵ�������ǰ����Ķ�Զ������ mappingName һ�¡�
     *
     * @var string
     */
    var $rolesField = 'roles';
}
