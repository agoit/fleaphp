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
 * 定义 MVC-Basic 示例的控制器
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage MVC-Basic
 * @version $Id: Default.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Controller_Default 控制器
 *
 * 控制器在 MVC 模式中所起的具体作用比较复杂。因为 MVC 模式本身也有很多种实现方式。
 *
 * 在 FleaPHP 实现的 MVC 模式中，控制器（Controller）通常接收从浏览器发送来的数据，
 * 然后调用模型（Model）对输入数据进行处理，并获得处理结果。
 *
 * 最后将结果传递给视图（View）。视图会负责将处理结果转变为 HTML 文档（实际上可以
 * 输出任何内容）返回给浏览器。
 *
 * 虽然在 FleaPHP 中，并不要求控制器必须从 FLEA_Controller_Action 类即成。
 * 但由于 FLEA_Controller_Action 提供一些简化编程的方法，因此从这个类派生我们自己的
 * 控制器是一种推荐的做法。
 *
 * @package Example
 * @subpackage MVC-Basic
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Controller_Default extends FLEA_Controller_Action
{
    /**
     * 默认控制器方法
     *
     * 虽然 FleaPHP 应用程序默认配置的控制器方法名为 index，但由于同时定义了
     * 控制器方法的前缀（应用程序设置 actionMethodPrefix 选项）为 action，
     * 因此控制器方法的实际函数名是“前缀+控制器方法名”。
     *
     * 所以此处的函数名为 actionIndex()。
     */
    function actionIndex() {
        /**
         * 用 get_singleton() 获取 Model 的对象实例。
         *
         * 该函数返回指定类的唯一一个实例。由于 get_singleton() 会尝试自动载入类
         * 定义文件，所以使用非常方便。
         */
        $modelSayName =& get_singleton('Model_SayName');
        /* @var $modelSayName Model_SayName */
        /**
         * 上面那行看上去奇怪的注释，是帮助诸如 Zend Development Environment 和
         * Eclipse PHP IDE 这样的编辑器识别 $modelSayName 变量的正确类型。
         */

        /**
         * 调用 Model 获取数据
         */
        $name = $modelSayName->say();

        /**
         * 在 FleaPHP，通常不需要直接获取视图对象。
         *
         * 而是调用 FLEA_Controller_Action::_executeView() 方法，直接输出视图。
         *
         * _executeView() 方法的第一个参数是视图的名字（大多数时候是视图的文件名，例如对于 Smarty
         * 来说，就是模版文件名），第二个参数是要传递给视图的变量（必须是一个数组）。
         */
        $viewData = array(
            'name' => $name,
        );
        $this->_executeView('View/DisplayName.php', $viewData);
    }
}
