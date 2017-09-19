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
 * ���� Controller_BoProducts ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoProducts.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * Controller_BoProducts �ṩ�˲�����Ʒ��Ϣ�ĺ�̨���湦��
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_BoProducts extends Controller_BoBase
{
    /**
     * ������Ʒ����Ķ���
     *
     * @var Model_ProductClasses
     */
    var $_modelClasses;

    /**
     * @var Model_Products
     */
    var $_modelProducts;

    /**
     * ���캯��
     *
     * @return Controller_BoProducts
     */
    function Controller_BoProducts() {
        parent::Controller_BoBase();
        $this->_modelClasses =& get_singleton('Model_ProductClasses');
        $this->_modelProducts =& get_singleton('Model_Products');
    }

    /**
     * ��ʾ�б�
     */
    function actionIndex() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
        load_class('FLEA_Helper_Pager');
        $table =& $this->_modelProducts->getTable();
        $pager =& new FLEA_Helper_Pager($table, $page);
        $pk = $table->primaryKey;
        $rowset = $pager->findAll();

        $this->_setBack();
        include(APP_DIR . '/BoProductsList.php');
    }

    /**
     * ��Ӳ�Ʒ
     */
    function actionCreate() {
        $table =& $this->_modelProducts->getTable();
        $product = $this->_prepareData($table->meta);
        $this->_editProduct($product);
    }

    /**
     * �޸Ĳ�Ʒ
     */
    function actionEdit() {
        $product = $this->_modelProducts->getProduct($_GET['id']);
        $this->_editProduct($product);
    }

    /**
     * ��ʾ��Ʒ��Ϣ�༭ҳ��
     *
     * @param array $product
     * @param string $errorMessage
     */
    function _editProduct($product, $errorMessage = '') {
        $table =& $this->_modelProducts->getTable();
        $pk = $table->primaryKey;
        $classes = $this->_modelClasses->getAllClasses();
        if (count($classes) == 0) {
            js_alert(_T('ui_p_create_class_first'), '', url('BoProductClasses'));
        }

        if (isset($product['classes']) && is_array($product['classes'])) {
            $product['classes'] = array_col_values($product['classes'], 'class_id');
        }
        include(APP_DIR . '/BoProductEdit.php');
    }

    /**
     * �����Ʒ��Ϣ
     */
    function actionSave() {
        __TRY();
        $this->_modelProducts->saveProduct($_POST);
        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            return $this->_editProduct($_POST, $ex->getMessage());
        }

        $this->_goBack();
    }

    /**
     * ɾ����Ʒ
     */
    function actionRemove() {
        $this->_modelProducts->removeProduct($_GET['id']);
        $this->_goBack();
    }

    /**
     * ��ʾ��Ʒ��ͼƬ������
     */
    function actionPicman($errorMessage = null) {
        $product = $this->_modelProducts->getProduct($_GET['id'], true);
        if (!$product) { $this->_goBack(); }
        $table =& $this->_modelProducts->getTable();
        $pk = $table->primaryKey;
        include(APP_DIR . '/BoProductPicman.php');
    }

    /**
     * �ϴ�����ͼ
     */
    function actionUploadThumb() {
        $this->_uploadPicture('thumb');
    }

    /**
     * ����ͼƬ�ϴ�
     */
    function _uploadPicture($pictureType) {
        $productId = (int)$_GET['id'];
        do {
            $uploader =& get_singleton('FLEA_Helper_FileUploader');
            /* @var $uploader FLEA_Helper_FileUploader */

            // ����ϴ��ļ��Ƿ����
            if (!$uploader->isFileExist('postfile')) {
                $errorMessage = _T('ui_p_upload_failed');
                break;
            }

            // ����ļ���չ���Ƿ��������ϴ�������
            $file =& $uploader->getFile('postfile');
            if (!$file->check(get_app_inf('thumbFileExts'))) {
                $errorMessage =_T('ui_p_invalid_filetype');
                break;
            }

            // Ϊָ����Ʒ��������ͼ
            __TRY();
            if ($pictureType == 'thumb') {
                $this->_modelProducts->uploadThumb($productId, $file);
            } else {
                $this->_modelProducts->uploadPhoto($productId, $file);
            }
            $ex = __CATCH();
            if (__IS_EXCEPTION($ex)) {
                $errorMessage = $ex->getMessage();
                break;
            }

            redirect($this->_url('picman', array('id' => $productId)));
        } while (false);

        $this->actionPicman($errorMessage);
    }

    /**
     * �ϴ�����ͼ
     */
    function actionUploadPhoto() {
        $this->_uploadPicture('photo');
    }

    /**
     * ɾ��ָ��ͼƬ
     */
    function actionRemovePhoto() {
        $this->_modelProducts->removePhoto($_GET['id'], $_GET['photo_id']);
        redirect($this->_url('picman', array('id' => (int)$_GET['id'])));
    }
}
