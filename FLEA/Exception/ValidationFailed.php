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
 * 定义 FLEA_Exception_ValidationFailed 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: ValidationFailed.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception_ValidationFailed 异常指示数据验证失败
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception_ValidationFailed extends FLEA_Exception
{
    /**
     * 被验证的数据
     *
     * @var mixed
     */
    var $data;

    /**
     * 验证结果
     *
     * @var array
     */
    var $result;

    /**
     * 构造函数
     *
     * @param array $result
     * @param mixed $data
     *
     * @return FLEA_Exception_ValidationFailed
     */
    function FLEA_Exception_ValidationFailed($result, $data = null) {
        $this->result = $result;
        $this->data = $data;
        $code = 0x0407001;
        $msg = sprintf(_E($code), implode(', ', array_keys((array)$result)));
        parent::FLEA_Exception($msg, $code);
    }
}
