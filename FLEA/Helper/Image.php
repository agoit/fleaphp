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
 * 定义 FLEA_Helper_Image 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Helper
 * @version $Id: Image.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Helper_Image 类封装了针对图像的操作
 *
 * @package Helper
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_Image
{
    /**
     * GD 资源句柄
     *
     * @var resource
     */
    var $_handle = null;

    /**
     * 构造函数
     *
     * @param resource $handle
     *
     * @return FLEA_Helper_Image
     */
    function FLEA_Helper_Image($handle) {
        $this->_handle = $handle;
    }

    /**
     * 从指定文件创建 Image 对象
     *
     * @param string $filename
     * @param string $fileext
     *
     * @return FLEA_Helper_Image
     */
    function & createFromFile($filename, $fileext) {
        $fileext = strtolower($fileext);
        $ext2functions = array(
            'jpg' => 'imagecreatefromjpeg',
            'jpeg' => 'imagecreatefromjpeg',
            'png' => 'imagecreatefrompng',
            'gif' => 'imagecreatefromgif',
        );
        if (!isset($ext2functions[$fileext])) {
            load_class('FLEA_Exception_NotImplemented');
            __THROW(new FLEA_Exception_NotImplemented('imagecreatefrom' . $fileext));
            return false;
        }

        $handle = $ext2functions[$fileext]($filename);
        return new FLEA_Helper_Image($handle);
    }

    /**
     * 快速缩放图像到指定大小（质量较差）
     *
     * @param int $width
     * @param int $height
     */
    function resize($width, $height) {
        if ($this->_handle == null) { return; }
        $dest = imagecreatetruecolor($width, $height);
        imagecopyresized($dest, $this->_handle, 0, 0, 0, 0,
            $width, $height, imagesx($this->_handle), imagesy($this->_handle));
        imagedestroy($this->_handle);
        $this->_handle = $dest;
    }

    /**
     * 缩放图像到指定大小（质量较好，速度比 resize() 慢）
     *
     * @param int $width
     * @param int $height
     */
    function resampled($width, $height) {
        if ($this->_handle == null) { return; }
        $dest = imagecreatetruecolor($width, $height);
        imagecopyresampled($dest, $this->_handle, 0, 0, 0, 0,
            $width, $height, imagesx($this->_handle), imagesy($this->_handle));
        imagedestroy($this->_handle);
        $this->_handle = $dest;
    }

    /**
     * 在保持图像长宽比的情况下将图像裁减到指定大小
     *
     * @param int $width
     * @param int $height
     * @param boolean $highQuality
     */
    function crop($width, $height, $highQuality = true) {
        if ($this->_handle == null) { return; }
        $dest = imagecreatetruecolor($width, $height);
        $sx = imagesx($this->_handle);
        $sy = imagesy($this->_handle);
        $ratio = doubleval($width) / doubleval($sx);
        if ($sy * $ratio < $height) {
            // 当按照比例缩放后的图像高度小于要求的高度时，只有放弃原始图像右边的部分内容
            $ratio = doubleval($sy) / doubleval($height);
            $sx = $width * $ratio;
        } elseif ($sy * $ratio > $height) {
            // 当按照比例缩放后的图像高度大于要求的高度时，只有放弃原始图像底部的部分内容
            $ratio = doubleval($sx) / doubleval($width);
            $sy = $height * $ratio;
        }

        if ($highQuality) {
            imagecopyresampled($dest, $this->_handle, 0, 0, 0, 0,
                $width, $height, $sx, $sy);
        } else {
            imagecopyresized($dest, $this->_handle, 0, 0, 0, 0,
                $width, $height, $sx, $sy);
        }

        imagedestroy($this->_handle);
        $this->_handle = $dest;
    }

    /**
     * 保存为 JPEG 文件
     *
     * @param string $filename
     * @param int $quality
     */
    function saveAsJpeg($filename, $quality = 80) {
        imagejpeg($this->_handle, $filename, $quality);
    }

    /**
     * 保存为 PNG 文件
     *
     * @param string $filename
     */
    function saveAsPng($filename) {
        imagepng($this->_handle, $filename);
    }

    /**
     * 保存为 GIF 文件
     *
     * @param string $filename
     */
    function saveAsGif($filename) {
        imagegif($this->_handle, $filename);
    }

    /**
     * 销毁图像
     */
    function destory() {
        imagedestroy($this->_handle);
        $this->_handle = null;
    }
}
