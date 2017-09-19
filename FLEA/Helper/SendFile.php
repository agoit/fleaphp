<?php
/////////////////////////////////////////////////////////////////////////////
// ����ļ��� FleaPHP ��Ŀ��һ����
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// Ҫ�鿴�����İ�Ȩ��Ϣ�������Ϣ����鿴Դ�����и����� COPYRIGHT �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * ���� FLEA_Helper_SendFile ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: SendFile.php 640 2006-12-19 11:51:09Z dualface $
 */

// {{{ constants
define('SENDFILE_ATTACHMENT', 'attachment');
define('SENDFILE_INLINE', 'inline');
// }}}

/**
 * FLEA_Helper_SendFile ������������������ļ�
 *
 * ���� FLEA_Helper_SendFile��Ӧ�ó�����Խ���Ҫ���ļ�������
 * ������޷����ʵ�λ�á�Ȼ��ͨ�������ļ����ݷ��͸��������
 *
 * @package Helper
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_SendFile
{
    /**
     * ������������ļ�����
     *
     * @param string $serverPath �ļ��ڷ������ϵ�·�������Ի������·����
     * @param string $filename ���͸���������ļ����������ܲ�Ҫʹ�����ģ�
     * @param string $mimeType ָʾ�ļ�����
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
