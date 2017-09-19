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
 * 定义 FLEA_Com_RBAC_Exception_InvalidACTFile 异常
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: InvalidACTFile.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Com_RBAC_Exception_InvalidACTFile 异常指示控制器的 ACT 文件无效
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_RBAC_Exception_InvalidACTFile extends FLEA_Exception
{
    /**
     * ACT 文件名
     *
     * @var string
     */
    var $actFilename;

    /**
     * 控制器名字
     *
     * @var string
     */
    var $controllerName;

    /**
     * 无效的 ACT 内容
     *
     * @var mixed
     */
    var $act;

    /**
     * 构造函数
     *
     * @param string $actFilename
     * @param string $controllerName
     * @param mixed $act
     *
     * @return FLEA_Com_RBAC_Exception_InvalidACTFile
     */
    function FLEA_Com_RBAC_Exception_InvalidACTFile($actFilename,
        $act, $controllerName = null)
    {
        $this->actFilename = $actFilename;
        $this->act = $act;
        $this->controllerName = $controllerName;

        if ($controllerName) {
            $code = 0x0701002;
            $msg = sprintf(_E($code), $actFilename, $controllerName);
        } else {
            $code = 0x0701003;
            $msg = sprintf(_E($code), $actFilename);
        }
        parent::FLEA_Exception($msg, $code);
    }
}
