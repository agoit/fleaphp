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
 * ���� FLEA_Com_RBAC_RolesManager ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package RBAC
 * @version $Id: RolesManager.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * FLEA_Com_RBAC_RolesManager ������ FLEA_Db_TableDataGateway��
 * ���ڷ��ʱ����ɫ��Ϣ�����ݱ�
 *
 * ������ݱ�����ֲ�ͬ��Ӧ�ô� FLEA_Com_RBAC_RolesManager
 * �����ಢʹ���Զ�������ݱ����֡������ֶ����ȡ�
 *
 * @package RBAC
 */
class FLEA_Com_RBAC_RolesManager extends FLEA_Db_TableDataGateway
{
    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey = 'role_id';

    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'roles';

    /**
     * ��ɫ���ֶ�
     *
     * @var string
     */
    var $rolesNameField = 'rolename';

    function FLEA_Com_RBAC_RolesManager() {
        log_message('Construction FLEA_Com_RBAC_RolesManager', 'debug');
        parent::FLEA_Db_TableDataGateway();
    }
}
