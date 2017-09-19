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
 * ���� Table_ProductPhotos ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductPhotos.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Table_ProductPhotos �ṩ��Ʒ��Ƭ�����ݿ���ʷ���
 *
 * @package package
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Table_ProductPhotos extends FLEA_Db_TableDataGateway
{
    /**
     * ���ݱ�����
     *
     * @var string
     */
    var $tableName = 'product_photos';

    /**
     * �����ֶ���
     *
     * @var string
     */
    var $primaryKey = 'photo_id';

    /**
     * �����ϴ����ļ��б�
     *
     * ������ϢΪһ���б��б���Ϊÿһ���ϴ��ļ��Ĵ�С��
     * ���ͣ���ͼƬ��������ͼ������ʱ�ļ�������Ϣ��
     *
     * @return array
     */
    function getUploadedFiles() {
        load_class('FLEA_Helper_FileUploader');
        $uploader =& new FLEA_Helper_FileUploader();
        $errors = array();

        if ($uploader->isFileExist('post_thumb')) {
            $thumb =& $uploader->getFile('post_thumb');
            if ($thumb->check(get_app_inf('thumbFileExts'))) {
                if (!function_exists('imagecreate')) {
                    load_class('FLEA_Exception_NotImplemented');
                    __THROW(new FLEA_Exception_NotImplemented('GD2 ext: imagecreate()'));
                    return false;
                }
                switch (strtolower($thumb->getExt())) {
                case '.gif':
                    $source = imagecreatefromgif($thumb->getTmpName());
                    break;
                case '.jpg':
                case '.jpeg':
                    $source = imagecreatefromjpeg($thumb->getTmpName());
                    break;
                case '.png':
                    $source = imagecreatefrompng($thumb->getTmpName());
                    break;
                }
                if (!$source) {
                    load_class('Exception_ImageFailed');
                    __THROW(new Exception_ImageFailed('imagecreatefrom'));
                    return false;
                }
            } else {

            }


            if ($havePhoto) {
                // ������Ʒ��ͼ�ϴ�
                if (!$uploader->isFileExist('post_photo')) {
                    $error = '�����ϴ���Ʒ��ͼ';
                    break;
                }

                $photo =& $uploader->getFile('post_photo');
                if (!$photo->check('.jpg/.jpeg/.png/.gif')) {
                    $error = '��Ʒ��ͼ���ļ���ʽ����ȷ';
                    break;
                }
            }
        } while(false);

        if ($error) {
            throw_error('GENERAL_ERROR', $error);
            return false;
        }

        if ($haveThumb) {
            // ��������ͼ
            $thumbFilename = md5($thumb->getFilename() . time()) . '.' . $thumb->getExt();
            $thumb->move($destDir . $thumbFilename);
            $row['thumb_file'] = $midDir . DIRECTORY_SEPARATOR . $thumbFilename;
        }

        if ($havePhoto) {
            // �����ͼ
            $photoFilename = md5($photo->getFilename() . time()) . '.' . $photo->getExt();
            $photo->move($destDir . $photoFilename);
            $row['photos'] = array();
            $row['photos'][] = array(
                'photo_file' => $midDir . DIRECTORY_SEPARATOR . $photoFilename,
            );
        }

        return true;
    }

}
