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
 * 定义 FLEA_Db_Exception_SqlQuery 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: SqlQuery.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_SqlQuery 异常指示一个 SQL 语句执行错误
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_SqlQuery extends FLEA_Exception
{
    /**
     * 发生错误的 SQL 语句
     *
     * @var string
     */
    var $sql;

    /**
     * 构造函数
     *
     * @param string $sql
     * @param string $msg
     * @param int $code
     *
     * @return FLEA_Db_Exception_SqlQuery
     */
    function FLEA_Db_Exception_SqlQuery($sql, $msg = 0, $code = 0) {
        $this->sql = $sql;
        if ($msg) {
            $code = 0x06ff005;
            $msg = sprintf(_E($code), $msg, $sql, $code);
        } else {
            $code = 0x06ff006;
            $msg = sprintf(_E($code), $sql, $code);
        }
        parent::FLEA_Exception($msg, $code);
    }
}
