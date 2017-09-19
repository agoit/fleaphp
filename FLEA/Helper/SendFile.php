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
 * 定义 FLEA_Helper_SendFile 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Helper
 * @version $Id: SendFile.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ constants
define('SENDFILE_ATTACHMENT', 'attachment');
define('SENDFILE_INLINE', 'inline');
// }}}

/**
 * FLEA_Helper_SendFile 类用于向浏览器发送文件
 *
 * 利用 FLEA_Helper_SendFile，应用程序可以将重要的文件保存在
 * 浏览器无法访问的位置。然后通过程序将文件内容发送给浏览器。
 *
 * @package Helper
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_SendFile
{
    /**
     * 向浏览器发送文件内容
     *
     * @param string $serverPath 文件在服务器上的路径（绝对或者相对路径）
     * @param string $filename 发送给浏览器的文件名（尽可能不要使用中文）
     * @param string $mimeType 指示文件类型
     */
    function sendFile($serverPath, $filename, $mimeType = 'application/octet-stream') {
        header("Content-Type: {$mimeType}");
        // $filename = iconv('GBK', 'UTF-8', $filename);
        $filename = '"' . htmlspecialchars($filename) . '"';
        $filesize = filesize($serverPath);
        header("Content-Disposition: attachment; filename={$filename}; charset=gb2312");
        header("Content-Length: {$filesize}");
        readfile($serverPath);
        exit;
    }
}
