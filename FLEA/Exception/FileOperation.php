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
 * 定义 FLEA_Exception_FileOperation 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: FileOperation.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_FileOperation 异常指示文件系统操作失败
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_FileOperation extends FLEA_Exception
{
    /**
     * 正在进行的文件操作
     *
     * @var string
     */
    var $operation;

    /**
     * 操作的参数
     *
     * @var array
     */
    var $args;

    /**
     * 构造函数
     *
     * @param string $opeation
     *
     * @return FLEA_Exception_FileOperation
     */
    function FLEA_Exception_FileOperation($opeation) {
        $this->operation = $opeation;
        $args = func_get_args();
        array_shift($args);
        $this->args = $args;
        $func = $opeation . '(' . implode(', ', $args) . ')';
        parent::FLEA_Exception(sprintf(_E(0x0102005), $func));
    }
}
