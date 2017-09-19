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
 * 定义 FLEA_Helper_FileUploader 和 FLEA_Helper_UploadFile 对象
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Helper
 * @version $Id: FileUploader.php 649 2006-12-25 10:57:12Z dualface $
 */

/**
 * FLEA_Helper_FileUploader 实现了一个简单的、可扩展的文件上传助手
 *
 * 使用方法：
 *
 * <code>
 * $allowExts = 'jpg,png,gif';
 * $maxSize = 150 * 1024; // 150KB
 * $uploadDir = dirname(__FILE__) . '/upload';
 *
 * load_class('FLEA_Helper_FileUploader');
 * $uploader =& new FLEA_Helper_FileUploader();
 * $files =& $uploader->getFiles();
 * foreach ($files as $file) {
 *     if (!$file->check($allowExts, $maxSize)) {
 *         // 上传的文件类型不符或者超过了大小限制。
 *         return false;
 *     }
 *     // 生成唯一的文件名（重复的可能性极小）
 *     $id = md5(time() . $file->getFilename() . $file->getSize() . $file->getTmpName());
 *     $filename = $id . '.' . strtolower($file->getExt());
 *     $file->move($uploadDir . '/' . $filename);
 * }
 * </code>
 *
 * @package Helper
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_FileUploader
{
    /**
     * 所有的 UploadFile 对象实例
     *
     * @var array
     */
    var $_files = array();

    /**
     * 可用的上传文件对象数量
     *
     * @var int
     */
    var $_count;

    /**
     * 构造函数
     *
     * @return FLEA_Helper_FileUploader
     */
    function FLEA_Helper_FileUploader() {
        log_message('Construction FLEA_Helper_FileUploader', 'debug');
        if (is_array($_FILES)) {
            foreach ($_FILES as $field => $struct) {
                if (isset($struct['error']) && $struct['error'] != UPLOAD_ERR_NO_FILE) {
                    $this->_files[$field] =& new FLEA_Helper_UploadFile($struct, $field);
                }
            }
        }
        $this->_count = count($this->_files);
    }

    /**
     * 可用的上传文件对象数量
     *
     * @return int
     */
    function getCount() {
        return $this->_count;
    }

    /**
     * 返回所有的上传文件对象
     *
     * @return array
     */
    function & getFiles() {
        return $this->_files;
    }

    /**
     * 返回指定名字的上传文件对象
     *
     * @param string $name
     *
     * @return FLEA_Helper_UploadFile
     */
    function & getFile($name) {
        if (!isset($this->_files[$name])) {
            load_class('FLEA_Exception_ExpectedFile');
            __THROW(new FLEA_Exception_ExpectedFile('$_FILES[' . $name . ']'));
            $return = false;
            return $return;
        }
        return $this->_files[$name];
    }

    /**
     * 检查指定的上传文件是否存在
     *
     * @param string $name
     *
     * @return boolean
     */
    function isFileExist($name) {
        return isset($this->_files[$name]);
    }

    /**
     * 批量移动上传的文件到目标目录
     *
     * @param string $destDir
     */
    function batchMove($destDir) {
        foreach ($this->_files as $file) {
            /* @var $file FLEA_Helper_UploadFile */
            $file->move($destDir . '/' . $file->getFilename());
        }
    }
}

/**
 * 封装一个上传的文件
 *
 * @package Helper
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_UploadFile
{
    /**
     * 上传文件信息
     *
     * @var array
     */
    var $_file = array();

    /**
     * 上传文件对象的名字
     *
     * @var string
     */
    var $_name;

    /**
     * 构造函数
     *
     * @param array $struct
     * @param string $name
     *
     * @return FLEA_Helper_UploadFile
     */
    function FLEA_Helper_UploadFile($struct, $name) {
        $this->_file = $struct;
        $this->_file['is_moved'] = false;
        $this->_name = $name;
    }

    /**
     * 设置自定义属性
     *
     * @param string $name
     * @param mixed $value
     */
    function setAttribute($name, $value) {
        $this->_file[$name] = $value;
    }

    /**
     * 获取自定义属性
     *
     * @param string $name
     *
     * @return mixed
     */
    function getAttribute($name) {
        return $this->_file[$name];
    }

    /**
     * 返回上传文件对象的名字
     *
     * @return string
     */
    function getName() {
        return $this->_name;
    }

    /**
     * 指示上传是否成功
     *
     * @return boolean
     */
    function isSuccessed() {
        return $this->_file['error'] == UPLOAD_ERR_OK;
    }

    /**
     * 返回上传错误代码
     *
     * @return int
     */
    function getError() {
        return $this->_file['error'];
    }

    /**
     * 指示上传文件是否已经从临时目录移出
     *
     * @return boolean
     */
    function isMoved() {
        return $this->_file['is_moved'];
    }

    /**
     * 返回上传文件的原名
     *
     * @return string
     */
    function getFilename() {
        return $this->_file['name'];
    }

    /**
     * 返回上传文件不带"."的扩展名
     *
     * @return string
     */
    function getExt() {
        if ($this->isMoved()) {
            $parts = pathinfo($this->getNewPath());
        } else {
            $parts = pathinfo($this->getFilename());
        }
        return $parts['extension'];
    }

    /**
     * 返回上传文件的大小（字节数）
     *
     * @return int
     */
    function getSize() {
        return $this->_file['size'];
    }

    /**
     * 返回上传文件的 MIME 类型（由浏览器提供，不可信）
     *
     * @return string
     */
    function getMimeType() {
        return $this->_file['type'];
    }

    /**
     * 返回上传文件的临时文件名
     *
     * @return string
     */
    function getTmpName() {
        return $this->_file['tmp_name'];
    }

    /**
     * 获得文件的新路径（通常是移动后的新路径，包括文件名）
     *
     * @return string
     */
    function getNewPath() {
        return $this->_file['new_path'];
    }

    /**
     * 检查上传的文件是否成功上传，并符合检查条件（文件类型、最大尺寸）
     *
     * 文件类型以扩展名为准，多个扩展名以 , 分割。
     *
     * @param string $allowExts
     * @param int $maxSize
     *
     * @return boolean
     */
    function check($allowExts = null, $maxSize = null) {
        if (!$this->isSuccessed()) { return false; }

        if ($allowExts) {
            if (strpos($allowExts, ',')) {
                $exts = explode(',', $allowExts);
            } elseif (strpos($allowExts, '/')) {
                $exts = explode('/', $allowExts);
            } elseif (strpos($allowExts, '|')) {
                $exts = explode('|', $allowExts);
            } else {
                $exts = array($allowExts);
            }

            $fileExt = strtolower($this->getExt());
            $passed = false;
            $exts = array_filter(array_map('trim', $exts), 'trim');
            foreach ($exts as $ext) {
                if (substr($ext, 0, 1) == '.') {
                    $ext = substr($ext, 1);
                }
                if ($fileExt == strtolower($ext)) {
                    $passed = true;
                    break;
                }
            }
            if (!$passed) {
                return false;
            }
        }

        if ($maxSize && $this->getSize() > $maxSize) {
            return false;
        }

        return true;
    }

    /**
     * 移动上传文件到指定位置和文件名
     *
     * @param string $destPath
     */
    function move($destPath) {
        $this->_file['is_moved'] = true;
        $this->_file['new_path'] = $destPath;
        return move_uploaded_file($this->_file['tmp_name'], $destPath);
    }

    /**
     * 删除移动后的文件
     */
    function removeMovedFile() {
        if ($this->_file['is_moved']) {
            unlink($this->_file['new_path']);
        }
    }
}
