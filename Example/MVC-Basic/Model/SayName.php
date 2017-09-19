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
 * 定义 Model_SayName 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage MVC-Basic
 * @version $Id: SayName.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Model_SayName 类是一个很简单的模型（Model）
 *
 * 在 FleaPHP 中，Model 并不需要从特定类继承。
 *
 * @package Example
 * @subpackage MVC-Basic
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Model_SayName
{
    /**
     * 返回一个名字
     */
    function say() {
        return 'My name is MVC-Basic.';
    }
}
