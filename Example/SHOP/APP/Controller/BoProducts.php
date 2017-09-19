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
 * 定义 Controller_BoProducts 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoProducts.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * Controller_BoProducts 提供了操作产品信息的后台界面功能
 *
 * @package Example
 * @subpackage SHOP
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Controller_BoProducts extends Controller_BoBase
{
    /**
     * 操作产品分类的对象
     *
     * @var Model_ProductClasses
     */
    var $_modelClasses;

    /**
     * @var Model_Products
     */
    var $_modelProducts;

    /**
     * 构造函数
     *
     * @return Controller_BoProducts
     */
    function Controller_BoProducts() {
        parent::Controller_BoBase();
        $this->_modelClasses =& get_singleton('Model_ProductClasses');
        $this->_modelProducts =& get_singleton('Model_Products');
    }

    /**
     * 显示列表
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
     * 添加产品
     */
    function actionCreate() {
        $table =& $this->_modelProducts->getTable();
        $product = $this->_prepareData($table->meta);
        $this->_editProduct($product);
    }

    /**
     * 修改产品
     */
    function actionEdit() {
        $product = $this->_modelProducts->getProduct($_GET['id']);
        $this->_editProduct($product);
    }

    /**
     * 显示产品信息编辑页面
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
     * 保存产品信息
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
     * 删除产品
     */
    function actionRemove() {
        $this->_modelProducts->removeProduct($_GET['id']);
        $this->_goBack();
    }

    /**
     * 显示产品的图片管理器
     */
    function actionPicman($errorMessage = null) {
        $product = $this->_modelProducts->getProduct($_GET['id'], true);
        if (!$product) { $this->_goBack(); }
        $table =& $this->_modelProducts->getTable();
        $pk = $table->primaryKey;
        include(APP_DIR . '/BoProductPicman.php');
    }

    /**
     * 上传缩略图
     */
    function actionUploadThumb() {
        $this->_uploadPicture('thumb');
    }

    /**
     * 处理图片上传
     */
    function _uploadPicture($pictureType) {
        $productId = (int)$_GET['id'];
        do {
            $uploader =& get_singleton('FLEA_Helper_FileUploader');
            /* @var $uploader FLEA_Helper_FileUploader */

            // 检查上传文件是否存在
            if (!$uploader->isFileExist('postfile')) {
                $errorMessage = _T('ui_p_upload_failed');
                break;
            }

            // 检查文件扩展名是否是允许上传的类型
            $file =& $uploader->getFile('postfile');
            if (!$file->check(get_app_inf('thumbFileExts'))) {
                $errorMessage =_T('ui_p_invalid_filetype');
                break;
            }

            // 为指定产品设置缩略图
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
     * 上传缩略图
     */
    function actionUploadPhoto() {
        $this->_uploadPicture('photo');
    }

    /**
     * 删除指定图片
     */
    function actionRemovePhoto() {
        $this->_modelProducts->removePhoto($_GET['id'], $_GET['photo_id']);
        redirect($this->_url('picman', array('id' => (int)$_GET['id'])));
    }
}
