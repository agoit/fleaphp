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
 * 定义 FLEA_Com_RBAC_UsersManager 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package RBAC
 * @version $Id: UsersManager.php 683 2007-01-05 16:27:22Z dualface $
 */

// {{{ constants
/**
 * 密码的加密方式
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
 * UsersManager 派生自 FLEA_Db_TableDataGateway，用于访问保存用户信息的数据表
 *
 * 如果数据表的名字不同，应该从 FLEA_Com_RBAC_UsersManager 派生类并使用自定义的数据表名字、主键字段名等。
 *
 * @package RBAC
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_RBAC_UsersManager extends FLEA_Db_TableDataGateway
{
    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey = 'user_id';

    /**
     * 数据表名字
     *
     * @var string
     */
    var $tableName = 'users';

    /**
     * 用户名字段的名字
     *
     * @var string
     */
    var $usernameField = 'username';

    /**
     * 电子邮件字段的名字
     *
     * @var string
     */
    var $emailField = 'email';

    /**
     * 密码字段的名字
     *
     * @var string
     */
    var $passwordField = 'password';

    /**
     * 角色字段的名字
     *
     * @var string
     */
    var $rolesField = 'roles';

    /**
     * 密码加密方式
     *
     * @var int
     */
    var $encodeMethod = PWD_CRYPT;

    /**
     * 构造函数
     */
    function FLEA_Com_RBAC_UsersManager() {
        log_message('Construction FLEA_Com_RBAC_UsersManager', 'debug');
        parent::FLEA_Db_TableDataGateway();
        $this->meta[strtoupper($this->emailField)]['complexType'] = 'EMAIL';
    }

    /**
     * 返回指定 ID 的用户
     *
     * @param mixed $id
     *
     * @return array
     */
    function findByUserId($id) {
        return $this->findByField($this->fullTableName . '.' . $this->primaryKey, $id);
    }

    /**
     * 返回指定用户名的用户
     *
     * @param string $username
     *
     * @return array
     */
    function findByUsername($username) {
        return $this->findByField($this->usernameField, $username);
    }

    /**
     * 返回指定电子邮件的用户
     *
     * @param string $email
     *
     * @return array
     */
    function findByEmail($email) {
        return $this->findByField($this->emailField, $email);
    }

    /**
     * 检查指定的用户ID是否已经存在
     *
     * @param mixed $id
     *
     * @return boolean
     */
    function existsUserId($id) {
        return $this->findCount($this->primaryKey . ' = ' . $this->dbo-qstr($id)) > 0;
    }

    /**
     * 检查指定的用户名是否已经存在
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
     * 检查指定的电子邮件地址是否已经存在
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
     * 验证指定的用户名和密码是否正确
     *
     * @param string $username 用户名
     * @param string $password 密码
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
     * 更新指定用户的密码
     *
     * @param string $username 用户名
     * @param string $oldPassword 现在使用的密码
     * @param string $newPassword 新密码
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
     * 直接更新密码
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
     * 检查密码的明文和密文是否符合
     *
     * @param string $cleartext 密码的明文
     * @param string $cryptograph 密文
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
     * 将密码明文转换为密文
     *
     * @param string $cleartext 要加密的明文
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
     * 返回指定用户的角色名数组
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
     * 更新用户信息时，禁止更新密码字段
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
     * 在更新到数据库之前加密密码
     */
    function _beforeUpdateDb(& $row) {
        $this->_encodeRecordPassword($row);
        return true;
    }

    /**
     * 在更新到数据库之前加密密码
     */
    function _beforeCreateDb(& $row) {
        $this->_encodeRecordPassword($row);
        return true;
    }

    /**
     * 将记录里面的密码字段值从明文转为加密后的密文
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
