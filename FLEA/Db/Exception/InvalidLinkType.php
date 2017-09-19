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
 * 定义 FLEA_Db_Exception_InvalidLinkType 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidLinkType.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Db_Exception_InvalidLinkType 异常指示无效的数据表关联类型
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Db_Exception_InvalidLinkType extends FLEA_Exception
{
    var $type;

    /**
     * 构造函数
     *
     * @param $type
     *
     * @return FLEA_Db_Exception_InvalidDSN
     */
    function FLEA_Db_Exception_InvalidLinkType($type) {
        $this->type = $type;
        $code = 0x0202001;
        parent::FLEA_Exception(sprintf(_E($code), $type), $code);
    }
}
