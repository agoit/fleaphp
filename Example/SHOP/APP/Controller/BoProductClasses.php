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
 * ���� Controller_BoProductClasses ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoProductClasses.php 641 2006-12-19 11:51:53Z dualface $
 */

// {{{ includes
load_class('Controller_BoBase');
// }}}

/**
 * Controller_BoProductClasses �ṩ�˲�����Ʒ����ĺ�̨���湦��
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_BoProductClasses extends Controller_BoBase
{
    /**
     * ��������Ķ���
     *
     * @var Model_ProductClasses
     */
    var $_modelClasses;

    /**
     * ���캯��
     *
     * @return Controller_BoProductClasses
     */
    function Controller_BoProductClasses() {
        parent::Controller_BoBase();
        $this->_modelClasses =& get_singleton('Model_ProductClasses');
    }

    /**
     * ��ʾ�����б�
     */
    function actionIndex() {
        /**
         * ��ȡָ���������µ�ֱ���ӷ���
         */
        $parentId = isset($_GET['parent_id']) ? (int)$_GET['parent_id'] : 0;
        if ($parentId) {
            $parent = $this->_modelClasses->getClass($parentId);
            if (!$parent) {
                js_alert(sprintf(_T('ui_c_invalid_parent_id'), $parentId),
                    '', $this->_url());
            }
            $subClasses = $this->_modelClasses->getSubClasses($parent);

            /**
             * ȷ����ǰ���ൽ�������������·��
             */
            $path = $this->_modelClasses->getPath($parent);
            $path[] = $parent;
        } else {
            $parent = null;
            $path = null;
            $subClasses = $this->_modelClasses->getAllTopClasses();
        }

        foreach ($subClasses as $offset => $class) {
            $subClasses[$offset]['child_count'] = $this->_modelClasses->calcAllChildCount($class);
        }

        $this->_setBack();
        include(APP_DIR . '/BoProductClassesIndex.php');
    }

    /**
     * �����·���
     */
    function actionCreate() {
        $class = array(
            'class_id'  => null,
            'name'      => null,
            'parent_id' => isset($_GET['parent_id']) ? (int)$_GET['parent_id'] : 0,
        );
        $this->_editClass($class);
    }

    /**
     * �޸ķ���
     */
    function actionEdit() {
        $class = $this->_modelClasses->getClass((int)$_GET['class_id']);
        if (!$class) {
            js_alert(sprintf(_T('ui_c_invalid_class_id'), $_GET['clsas_id']),
                '', $this->_getBack());
        }
        $this->_editClass($class);
    }

    /**
     * ��ʾ��ӻ��޸ķ�����Ϣҳ��
     *
     * @param array $class
     */
    function _editClass($class) {
        $parentId = $class['parent_id'];
        if ($parentId) {
            $parent = $this->_modelClasses->getClass($parentId);
            if (!$parent) {
                js_alert(sprintf(_T('ui_c_invalid_parent_id'), $parentId),
                    '', $this->_url());
            }

            /**
             * ȷ����ǰ���ൽ�������������·��
             */
            $path = $this->_modelClasses->getPath($parent);
            $path[] = $parent;
        } else {
            $parent = array(
                'class_id' => 0,
                'name' => _T('ui_c_new_top_class'),
            );
            $path = array($parent);
        }
        include(APP_DIR . '/BoProductClassesEdit.php');
    }

    /**
     * ���������Ϣ�����ݿ�
     */
    function actionSave() {
        $class = array(
            'name' => $_POST['name'],
        );

        __TRY();
        if ($_POST['class_id']) {
            // ���·���
            $class['class_id'] = $_POST['class_id'];
            $this->_modelClasses->updateClass($class);
        } else {
            // ��������
            $this->_modelClasses->createClass($class, $_POST['parent_id']);
        }

        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), '', $this->_getBack());
        }
        $this->_goBack();
    }

    /**
     * ɾ������
     */
    function actionRemove() {
        __TRY();
        $this->_modelClasses->removeClassById($_GET['class_id']);
        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), '', $this->_getBack());
        }
        $this->_goBack();
    }
}
