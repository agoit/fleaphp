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
 * 定义 FLEA_Exception_NotNotExistsKeyName 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: NotExistsKeyName.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_NotExistsKeyName 异常指示需要的键名不存在
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_NotExistsKeyName extends FLEA_Exception
{
    var $keyname;

    /**
     * 构造函数
     *
     * @param string $keyname
     *
     * @return FLEA_Exception_NotExistsKeyName
     */
    function FLEA_Exception_NotExistsKeyName($keyname) {
        $this->keyname = $keyname;
        parent::FLEA_Exception(sprintf(_E(0x0102009), $keyname));
    }
}
