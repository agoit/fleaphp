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
 * 定义 FLEA_Db_Exception_PrimaryKeyExists 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: PrimaryKeyExists.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_PrimaryKeyExists 异常指示在不需要主键值的时候却提供了主键值
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_PrimaryKeyExists extends FLEA_Exception
{
    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey;

    /**
     * 主键字段值
     *
     * @var mixed
     */
    var $pkValue;

    /**
     * 构造函数
     *
     * @param string $pk
     * @param mixed $pkValue
     *
     * @return FLEA_Db_Exception_PrimaryKeyExists
     */
    function FLEA_Db_Exception_PrimaryKeyExists($pk, $pkValue = null) {
        $this->primaryKey = $pk;
        $this->pkValue = $pkValue;
        $code = 0x06ff004;
        $msg = sprintf(_E($code), $pk, $pkValue);
        parent::FLEA_Exception($msg, $code);
    }
}
