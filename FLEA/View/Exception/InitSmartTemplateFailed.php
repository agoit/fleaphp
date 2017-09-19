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
 * 定义 FLEA_View_Exception_InitSmartTemplateFailed 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: InitSmartTemplateFailed.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_View_Exception_InitSmartTemplateFailed 指示 FLEA_View_SmartTemplate 无法初始化 SmartTemplate 模版引擎
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_View_Exception_InitSmartTemplateFailed extends FLEA_Exception
{
    function FLEA_View_Exception_InitSmartTemplateFailed($filename) {
        $code = 0x0903002;
        parent::FLEA_Exception(sprintf(_E($code), $filename), $code);
    }
}
