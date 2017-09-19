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
 * ���� FLEA_Com_RBAC_UsersManager ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package RBAC
 * @version $Id: UsersManager.php 683 2007-01-05 16:27:22Z dualface $
 */

// {{{ constants
/**
 * ����ļ��ܷ�ʽ
 */
define('PWD_MD5',       1);
define('PWD_CRYPT',     2);
define('PWD_CLEARTEXT', 3);
define('PWD_SHA1',      4);
define('PWD_SHA2',      5);
// }}}

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * UsersManager ������ FLEA_Db_TableDataGateway�����ڷ��ʱ����û���Ϣ�����ݱ�
 *
 * ������ݱ�����ֲ�ͬ��Ӧ�ô� FLEA_Com_RBAC_UsersManager �����ಢʹ���Զ�������ݱ����֡������ֶ����ȡ�
 *
 * @package RBAC
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_RBAC_UsersManager extends FLEA_Db_TableDataGateway
{
    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey = 'user_id';

    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'users';

    /**
     * �û����ֶε�����
     *
     * @var string
     */
    var $usernameField = 'username';

    /**
     * �����ʼ��ֶε�����
     *
     * @var string
     */
    var $emailField = 'email';

    /**
     * �����ֶε�����
     *
     * @var string
     */
    var $passwordField = 'password';

    /**
     * ��ɫ�ֶε�����
     *
     * @var string
     */
    var $rolesField = 'roles';

    /**
     * ������ܷ�ʽ
     *
     * @var int
     */
    var $encodeMethod = PWD_CRYPT;

    /**
     * ���캯��
     */
    function FLEA_Com_RBAC_UsersManager() {
        log_message('Construction FLEA_Com_RBAC_UsersManager', 'debug');
        parent::FLEA_Db_TableDataGateway();
        $this->meta[strtoupper($this->emailField)]['complexType'] = 'EMAIL';
    }

    /**
     * ����ָ�� ID ���û�
     *
     * @param mixed $id
     *
     * @return array
     */
    function findByUserId($id) {
        return $this->findByField($this->fullTableName . '.' . $this->primaryKey, $id);
    }

    /**
     * ����ָ���û������û�
     *
     * @param string $username
     *
     * @return array
     */
    function findByUsername($username) {
        return $this->findByField($this->usernameField, $username);
    }

    /**
     * ����ָ�������ʼ����û�
     *
     * @param string $email
     *
     * @return array
     */
    function findByEmail($email) {
        return $this->findByField($this->emailField, $email);
    }

    /**
     * ���ָ�����û�ID�Ƿ��Ѿ�����
     *
     * @param mixed $id
     *
     * @return boolean
     */
    function existsUserId($id) {
        return $this->findCount($this->primaryKey . ' = ' . $this->dbo-qstr($id)) > 0;
    }

    /**
     * ���ָ�����û����Ƿ��Ѿ�����
     *
     * @param string $username
     *
     * @return boolean
     */
    function existsUsername($username) {
        return $this->findCount($this->usernameField . ' = ' .
            $this->dbo->qstr($username)) > 0;
    }

    /**
     * ���ָ���ĵ����ʼ���ַ�Ƿ��Ѿ�����
     *
     * @param string $email
     *
     * @return boolean
     */
    function existsEmail($email) {
        return $this->findCount($this->emailField . ' = ' .
            $this->dbo->qstr($email)) > 0;
    }

    /**
     * ��ָ֤�����û����������Ƿ���ȷ
     *
     * @param string $username �û���
     * @param string $password ����
     *
     * @return boolean
     *
     * @access public
     */
    function validateUser($username, $password) {
        $user = $this->findByField($this->usernameField, $username, null,
            $this->passwordField);
        if (!$user) { return false; }
        return $this->checkPassword($password, $user[$this->passwordField]);
    }

    /**
     * ����ָ���û�������
     *
     * @param string $username �û���
     * @param string $oldPassword ����ʹ�õ�����
     * @param string $newPassword ������
     *
     * @return boolean
     *
     * @access public
     */
    function changePassword($username, $oldPassword, $newPassword) {
        $oldAutoLink = $this->autoLink;
        $this->autoLink = false;
        $user = $this->findByField(
            $this->usernameField, $username, null,
            $this->primaryKey . ', ' . $this->passwordField
        );
        $this->autoLink = $oldAutoLink;
        if (!$user) { return false; }
        if (!$this->checkPassword($oldPassword, $user[$this->passwordField])) {
            return false;
        }

        $user[$this->passwordField] = $newPassword;
        return parent::update($user);
    }

    /**
     * ֱ�Ӹ�������
     *
     * @param mixed $userId
     * @param string $newPassword
     *
     * @return boolean
     */
    function updatePassword($username, $newPassword) {
        $oldAutoLink = $this->autoLink;
        $this->autoLink = false;
        $user = $this->findByField(
            $this->usernameField, $username, null,
            $this->primaryKey
        );
        $this->autoLink = $oldAutoLink;
        if (!$user) { return false; }

        $user[$this->passwordField] = $newPassword;
        return parent::update($user);
    }

    /**
     * �����������ĺ������Ƿ����
     *
     * @param string $cleartext ���������
     * @param string $cryptograph ����
     *
     * @return boolean
     *
     * @access public
     */
    function checkPassword($cleartext, $cryptograph) {
        switch ($this->encodeMethod) {
        case PWD_MD5:
            return (md5($cleartext) == rtrim($cryptograph));
        case PWD_CRYPT:
            return (crypt($cleartext, $cryptograph) == rtrim($cryptograph));
        case PWD_CLEARTEXT:
            return ($cleartext == rtrim($cryptograph));
        case PWD_SHA1:
            return (sha1($cleartext) == rtrim($cryptograph));
        case PWD_SHA2:
            return (hash('sha512', $cleartext) == rtrim($cryptograph));

        default:
            return false;
        }
    }

    /**
     * ����������ת��Ϊ����
     *
     * @param string $cleartext Ҫ���ܵ�����
     *
     * @return string
     *
     * @access public
     */
    function encodePassword($cleartext) {
        switch ($this->encodeMethod) {
        case PWD_MD5:
            return md5($cleartext);
        case PWD_CRYPT:
            return crypt($cleartext);
        case PWD_CLEARTEXT:
            return $cleartext;
        case PWD_SHA1:
            return sha1($cleartext);
        case PWD_SHA2:
            return hash('sha512', $cleartext);

        default:
            return false;
        }
    }

    /**
     * ����ָ���û��Ľ�ɫ������
     *
     * @param array $user
     * @param string $rolenameField
     *
     * @return array
     */
    function fetchRoles(& $user, $rolenameField = 'rolename') {
        if (!isset($user[$this->rolesField]) ||
            !is_array($user[$this->rolesField])) {
            return array();
        }
        $roles = array();
        foreach ($user[$this->rolesField] as $role) {
            $roles[] = $role[$rolenameField];
        }
        return $roles;
    }

    /**
     * �����û���Ϣʱ����ֹ���������ֶ�
     *
     * @param array $row
     *
     * @return boolean
     */
    function update(& $row) {
        unset($row[$this->passwordField]);
        return parent::update($row);
    }

    /**
     * �ڸ��µ����ݿ�֮ǰ��������
     */
    function _beforeUpdateDb(& $row) {
        $this->_encodeRecordPassword($row);
        return true;
    }

    /**
     * �ڸ��µ����ݿ�֮ǰ��������
     */
    function _beforeCreateDb(& $row) {
        $this->_encodeRecordPassword($row);
        return true;
    }

    /**
     * ����¼����������ֶ�ֵ������תΪ���ܺ������
     *
     * @param array $row
     */
    function _encodeRecordPassword(& $row) {
        if (isset($row[$this->passwordField])) {
            $row[$this->passwordField] =
                $this->encodePassword($row[$this->passwordField]);
        }
    }
}
