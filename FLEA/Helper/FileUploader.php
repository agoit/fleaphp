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
 * ���� FLEA_Helper_FileUploader �� FLEA_Helper_UploadFile ����
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: FileUploader.php 649 2006-12-25 10:57:12Z dualface $
 */

/**
 * FLEA_Helper_FileUploader ʵ����һ���򵥵ġ�����չ���ļ��ϴ�����
 *
 * ʹ�÷�����
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
 *         // �ϴ����ļ����Ͳ������߳����˴�С���ơ�
 *         return false;
 *     }
 *     // ����Ψһ���ļ������ظ��Ŀ����Լ�С��
 *     $id = md5(time() . $file->getFilename() . $file->getSize() . $file->getTmpName());
 *     $filename = $id . '.' . strtolower($file->getExt());
 *     $file->move($uploadDir . '/' . $filename);
 * }
 * </code>
 *
 * @package Helper
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_FileUploader
{
    /**
     * ���е� UploadFile ����ʵ��
     *
     * @var array
     */
    var $_files = array();

    /**
     * ���õ��ϴ��ļ���������
     *
     * @var int
     */
    var $_count;

    /**
     * ���캯��
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
     * ���õ��ϴ��ļ���������
     *
     * @return int
     */
    function getCount() {
        return $this->_count;
    }

    /**
     * �������е��ϴ��ļ�����
     *
     * @return array
     */
    function & getFiles() {
        return $this->_files;
    }

    /**
     * ����ָ�����ֵ��ϴ��ļ�����
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
     * ���ָ�����ϴ��ļ��Ƿ����
     *
     * @param string $name
     *
     * @return boolean
     */
    function isFileExist($name) {
        return isset($this->_files[$name]);
    }

    /**
     * �����ƶ��ϴ����ļ���Ŀ��Ŀ¼
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
 * ��װһ���ϴ����ļ�
 *
 * @package Helper
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_UploadFile
{
    /**
     * �ϴ��ļ���Ϣ
     *
     * @var array
     */
    var $_file = array();

    /**
     * �ϴ��ļ����������
     *
     * @var string
     */
    var $_name;

    /**
     * ���캯��
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
     * �����Զ�������
     *
     * @param string $name
     * @param mixed $value
     */
    function setAttribute($name, $value) {
        $this->_file[$name] = $value;
    }

    /**
     * ��ȡ�Զ�������
     *
     * @param string $name
     *
     * @return mixed
     */
    function getAttribute($name) {
        return $this->_file[$name];
    }

    /**
     * �����ϴ��ļ����������
     *
     * @return string
     */
    function getName() {
        return $this->_name;
    }

    /**
     * ָʾ�ϴ��Ƿ�ɹ�
     *
     * @return boolean
     */
    function isSuccessed() {
        return $this->_file['error'] == UPLOAD_ERR_OK;
    }

    /**
     * �����ϴ��������
     *
     * @return int
     */
    function getError() {
        return $this->_file['error'];
    }

    /**
     * ָʾ�ϴ��ļ��Ƿ��Ѿ�����ʱĿ¼�Ƴ�
     *
     * @return boolean
     */
    function isMoved() {
        return $this->_file['is_moved'];
    }

    /**
     * �����ϴ��ļ���ԭ��
     *
     * @return string
     */
    function getFilename() {
        return $this->_file['name'];
    }

    /**
     * �����ϴ��ļ�����"."����չ��
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
     * �����ϴ��ļ��Ĵ�С���ֽ�����
     *
     * @return int
     */
    function getSize() {
        return $this->_file['size'];
    }

    /**
     * �����ϴ��ļ��� MIME ���ͣ���������ṩ�������ţ�
     *
     * @return string
     */
    function getMimeType() {
        return $this->_file['type'];
    }

    /**
     * �����ϴ��ļ�����ʱ�ļ���
     *
     * @return string
     */
    function getTmpName() {
        return $this->_file['tmp_name'];
    }

    /**
     * ����ļ�����·����ͨ�����ƶ������·���������ļ�����
     *
     * @return string
     */
    function getNewPath() {
        return $this->_file['new_path'];
    }

    /**
     * ����ϴ����ļ��Ƿ�ɹ��ϴ��������ϼ���������ļ����͡����ߴ磩
     *
     * �ļ���������չ��Ϊ׼�������չ���� , �ָ
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
     * �ƶ��ϴ��ļ���ָ��λ�ú��ļ���
     *
     * @param string $destPath
     */
    function move($destPath) {
        $this->_file['is_moved'] = true;
        $this->_file['new_path'] = $destPath;
        return move_uploaded_file($this->_file['tmp_name'], $destPath);
    }

    /**
     * ɾ���ƶ�����ļ�
     */
    function removeMovedFile() {
        if ($this->_file['is_moved']) {
            unlink($this->_file['new_path']);
        }
    }
}
