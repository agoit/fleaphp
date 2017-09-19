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
 * ���� Model_Products ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: Products.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Model_Products ��װ�˶���Ʒ��Ϣ�����в���
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Model_Products
{
    /**
     * �ṩ��Ʒ��Ϣ���ݿ���ʷ���Ķ���
     *
     * @var Table_Products
     */
    var $_tbProducts;

    /**
     * ���캯��
     *
     * @return Model_Products
     */
    function Model_Products() {
        $this->_tbProducts =& get_singleton('Table_Products');
    }

    /**
     * ��ȡָ�� ID �Ĳ�Ʒ��Ϣ
     *
     * @param int $productId
     * @param boolean $withAssoc ָʾ�Ƿ��ȡ��Ʒ�Ĺ�����Ϣ�����༰��Ƭ��
     *
     * @return array
     */
    function getProduct($productId, $withAssoc = true) {
        $link =& $this->_tbProducts->getLinkByName('classes');
        $link->enabled = $withAssoc;
        $link =& $this->_tbProducts->getLinkByName('photos');
        $link->enabled = $withAssoc;

        return $this->_tbProducts->find((int)$productId);
    }

    /**
     * �����Ʒ��Ϣ
     *
     * @param array $product
     *
     * @return boolean
     */
    function saveProduct($product) {
        if (isset($product['product_id']) && (int)$product['product_id'] == 0) {
            unset($product['product_id']);
        }
        return $this->_tbProducts->save($product);
    }

    /**
     * ɾ��ָ���Ĳ�Ʒ��Ϣ
     *
     * @param int $productId
     *
     * @return boolean
     */
    function removeProduct($productId) {
        $productId = (int)$productId;
        $link =& $this->_tbProducts->getLinkByName('classes');
        $link->enabled = true;
        $link =& $this->_tbProducts->getLinkByName('photos');
        $link->enabled = true;

        $product = $this->_tbProducts->find($productId);
        if (!$product) {
            load_class('Exception_ProductNotFound');
            __THROW(new Exception_ProductNotFound($productId));
            return false;
        }

        $uploadDir = get_app_inf('uploadDir') . DS;
        if ($product['thumb_filename'] != '') {
            unlink($uploadDir . $product['thumb_filename']);
        }
        foreach ($product['photos'] as $photo) {
            unlink($uploadDir . $photo['photo_filename']);
        }
        return $this->_tbProducts->removeByPkv($productId);
    }

    /**
     * ����ָ����Ʒ������ͼ
     *
     * @param int $product
     * @param FLEA_Helper_UploadFile $file
     *
     * @return boolean
     */
    function uploadThumb($productId, & $file) {
        $productId = (int)$productId;
        $product = $this->getProduct($productId, false);
        if (!$product) {
            load_class('Exception_ProductNotFound');
            __THROW(new Exception_ProductNotFound($productId));
            return false;
        }

        // ������ͼ�ļ��ü�Ϊָ����С������������
        load_class('FLEA_Helper_Image');
        $image =& FLEA_Helper_Image::createFromFile($file->getTmpName(), $file->getExt());
        $image->crop(get_app_inf('thumbWidth'), get_app_inf('thumbHeight'));
        $filename = $productId . '-thumb-t' . time() . '.jpg';
        $image->saveAsJpeg(get_app_inf('uploadDir') . DS . $filename);
        $image->destory();

        // �������ݿ�
        if ($product['thumb_filename'] != '') {
            unlink(get_app_inf('uploadDir') . DS . $product['thumb_filename']);
        }

        $product['thumb_filename'] = $filename;
        return $this->_tbProducts->update($product);
    }

    /**
     * Ϊָ����Ʒ���һ����ͼƬ
     *
     * @param int $product
     * @param FLEA_Helper_UploadFile $file
     *
     * @return boolean
     */
    function uploadPhoto($productId, & $file) {
        $productId = (int)$productId;
        $product = $this->getProduct($productId, false);
        if (!$product) {
            load_class('Exception_ProductNotFound');
            __THROW(new Exception_ProductNotFound($productId));
            return false;
        }

        $filename = $productId . '-photo-t' . time() . '.jpg';
        $file->move(get_app_inf('uploadDir') . DS . $filename);
        $product['photos'] = array(
            array('product_id' => $productId, 'photo_filename' => $filename)
        );
        $link =& $this->_tbProducts->getLinkByName('photos');
        $link->enabled = true;
        $link =& $this->_tbProducts->getLinkByName('classes');
        $link->enabled = false;
        return $this->_tbProducts->update($product);
    }

    /**
     * ɾ��ָ����Ʒ��һ����ͼƬ
     *
     * @param int $productId
     * @param int $photoId
     *
     * @return boolean
     */
    function removePhoto($productId, $photoId) {
        $productId = (int)$productId;
        $photoId = (int)$photoId;
        $tableProductPhotos =& get_singleton('Table_ProductPhotos');
        /* @var $tableProductPhotos Table_ProductPhotos */
        $photo = $tableProductPhotos->find("product_id = {$productId} AND photo_id = {$photoId}");
        if (!$photo) { return false; }
        unlink(get_app_inf('uploadDir') . DS . $photo['photo_filename']);
        $tableProductPhotos->removeByPkv($photo[$tableProductPhotos->primaryKey]);

        return true;
    }

    /**
     * ���� Table_Products ����
     *
     * @return Table_Products
     */
    function & getTable() {
        return $this->_tbProducts;
    }
}
