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
 * ���� Controller_BoBase ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: BoBase.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Controller_BoBase �Ǻ�̨�������Ļ��࣬�ṩһЩ��������
 *
 * @package Example
 * @subpackage SHOP
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_BoBase extends FLEA_Controller_Action
{
    /**
     * ���캯��
     *
     * ��������û��� session �������������ļ�
     *
     * @return Controller_BoBase
     */
    function Controller_BoBase() {
        if (isset($_SESSION['LANG'])) {
            $lang = $_SESSION['LANG'];
            $languages = get_app_inf('languages');
            if (isset($languages[$lang])) {
                set_app_inf('defaultLanguage', $lang);
            }
        }
        load_language('ui, exception');
    }

    /**
     * �������ݱ��Ԫ���ݷ���һ�����飬����������������Ҫ��ʼ�������ݣ��������ڽ�����ʾ
     *
     * @param array $meta
     *
     * @return array
     */
    function _prepareData(& $meta) {
        $data = array();
        foreach ($meta as $m) {
            if (isset($_POST[$m['name']])) {
                $data[$m['name']] = $_POST[$m['name']];
            } else {
                if (isset($m['defaultValue'])) {
                    $data[$m['name']] = $m['defaultValue'];
                } else {
                    $data[$m['name']] = null;
                }
            }
        }
        return $data;
    }

    /**
     * ������ _setBack() ���õ� URL
     */
    function _goBack() {
        $url = $this->_getBack();
        unset($_SESSION['BACKURL']);
        redirect($url);
    }

    /**
     * ���÷��ص� URL���Ժ������ _goBack() ����
     */
    function _setBack() {
        $_SESSION['BACKURL'] = encode_url_args($_GET);
    }

    /**
     * ��ȡ���ص� URL
     *
     * @return string
     */
    function _getBack() {
        if (isset($_SESSION['BACKURL'])) {
            $url = $this->rawurl($_SESSION['BACKURL']);
        } else {
            $url = $this->_url();
        }
        return $url;
    }

    /**
     * ֱ���ṩ��ѯ�ַ��������� URL ��ַ
     *
     * @param string $queryString
     *
     * @return string
     */
    function rawurl($queryString) {
    	if (substr($queryString, 0, 1) == '?') {
    		$queryString = substr($queryString, 1);
    	}
    	return $_SERVER['SCRIPT_NAME'] . '?' . $queryString;
    }
}
