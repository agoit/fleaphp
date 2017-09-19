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
 * 定义 Table_ProductPhotos 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ProductPhotos.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * Table_ProductPhotos 提供商品照片的数据库访问服务
 *
 * @package package
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Table_ProductPhotos extends FLEA_Db_TableDataGateway
{
    /**
     * 数据表名称
     *
     * @var string
     */
    var $tableName = 'product_photos';

    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey = 'photo_id';

    /**
     * 返回上传的文件列表
     *
     * 返回信息为一个列表，列表中为每一个上传文件的大小、
     * 类型（大图片还是缩略图）、临时文件名等信息。
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
                // 处理商品大图上传
                if (!$uploader->isFileExist('post_photo')) {
                    $error = '必须上传商品大图';
                    break;
                }

                $photo =& $uploader->getFile('post_photo');
                if (!$photo->check('.jpg/.jpeg/.png/.gif')) {
                    $error = '商品大图的文件格式不正确';
                    break;
                }
            }
        } while(false);

        if ($error) {
            throw_error('GENERAL_ERROR', $error);
            return false;
        }

        if ($haveThumb) {
            // 保存缩略图
            $thumbFilename = md5($thumb->getFilename() . time()) . '.' . $thumb->getExt();
            $thumb->move($destDir . $thumbFilename);
            $row['thumb_file'] = $midDir . DIRECTORY_SEPARATOR . $thumbFilename;
        }

        if ($havePhoto) {
            // 保存大图
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
