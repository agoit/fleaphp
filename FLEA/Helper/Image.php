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
 * ���� FLEA_Helper_Image ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: Image.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Helper_Image ���װ�����ͼ��Ĳ���
 *
 * @package Helper
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_Image
{
    /**
     * GD ��Դ���
     *
     * @var resource
     */
    var $_handle = null;

    /**
     * ���캯��
     *
     * @param resource $handle
     *
     * @return FLEA_Helper_Image
     */
    function FLEA_Helper_Image($handle) {
        $this->_handle = $handle;
    }

    /**
     * ��ָ���ļ����� Image ����
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
     * ��������ͼ��ָ����С�������ϲ
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
     * ����ͼ��ָ����С�������Ϻã��ٶȱ� resize() ����
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
     * �ڱ���ͼ�񳤿�ȵ�����½�ͼ��ü���ָ����С
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
            // �����ձ������ź��ͼ��߶�С��Ҫ��ĸ߶�ʱ��ֻ�з���ԭʼͼ���ұߵĲ�������
            $ratio = doubleval($sy) / doubleval($height);
            $sx = $width * $ratio;
        } elseif ($sy * $ratio > $height) {
            // �����ձ������ź��ͼ��߶ȴ���Ҫ��ĸ߶�ʱ��ֻ�з���ԭʼͼ��ײ��Ĳ�������
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
     * ����Ϊ JPEG �ļ�
     *
     * @param string $filename
     * @param int $quality
     */
    function saveAsJpeg($filename, $quality = 80) {
        imagejpeg($this->_handle, $filename, $quality);
    }

    /**
     * ����Ϊ PNG �ļ�
     *
     * @param string $filename
     */
    function saveAsPng($filename) {
        imagepng($this->_handle, $filename);
    }

    /**
     * ����Ϊ GIF �ļ�
     *
     * @param string $filename
     */
    function saveAsGif($filename) {
        imagegif($this->_handle, $filename);
    }

    /**
     * ����ͼ��
     */
    function destory() {
        imagedestroy($this->_handle);
        $this->_handle = null;
    }
}
