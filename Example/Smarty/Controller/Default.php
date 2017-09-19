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
 * 定义 Controller_Default 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage Smarty
 * @version $Id: Default.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Controller_Default 类是 Smarty 示例的默认控制器
 *
 * @package Example
 * @subpackage Smarty
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Controller_Default extends FLEA_Controller_Action
{
    /**
     * 默认控制器方法
     */
    function actionIndex() {
        $smarty =& $this->_getView();
        /* @var $smarty Smarty */
        $smarty->assign('my_var', 'The smarty template engine.');
        $smarty->display('tpl-index.html');
    }

    /**
     * 演示另一种使用 Smarty 的方法
     */
    function actionAlternative() {
        $viewData = array(
            'my_var' => 'The smarty template engine.',
        );
        $this->_executeView('tpl-alternative.html', $viewData);
    }
}
