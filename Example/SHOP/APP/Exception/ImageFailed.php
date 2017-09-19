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
 * 定义 Exception_ImageFailed 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ImageFailed.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Exception_ImageFailed 指示图像操作失败
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Exception_ImageFailed extends FLEA_Exception
{
    var $operation;

    function Exception_ImageFailed($operation) {
        $this->operation = $operation;
        parent::FLEA_Exception(sprintf(_T('ex_image_failed'), $operation));
    }
}
