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
 * 定义 FLEA_Com_RBAC_Exception_InvalidACT 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidACT.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Com_RBAC_Exception_InvalidACT 异常指示一个无效的 ACT
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_RBAC_Exception_InvalidACT extends FLEA_Exception
{
    /**
     * 无效的 ACT 内容
     *
     * @var mixed
     */
    var $act;

    /**
     * 构造函数
     *
     * @param mixed $act
     *
     * @return FLEA_Com_RBAC_Exception_InvalidACT
     */
    function FLEA_Com_RBAC_Exception_InvalidACT($act) {
        $this->act = $act;
        $code = 0x0701001;
        parent::FLEA_Exception(_E($code), $code);
    }
}
