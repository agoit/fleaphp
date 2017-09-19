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
 * 定义 Exception_ProductNotFound 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductNotFound.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Exception_ProductNotFound 指示产品不存在
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Exception_ProductNotFound extends FLEA_Exception
{
    var $productId;

    function Exception_ProductNotFound($productId) {
        $this->nodeId = $productId;
        parent::FLEA_Exception(sprintf(_T('ex_product_not_found'), $productId));
    }
}
