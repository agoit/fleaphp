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
 * ���� FLEA_Com_Language ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package I18N
 * @version $Id: Language.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * ���� FLEA_Com_Language::get() ��ȡ����
 *
 * �÷���
 * <code>
 * $msg = _T('ENGLISH', 'chinese');
 * $msg = sprintf(_T('ENGLISH: %s'), 'chinese');
 * </code>
 *
 * @param string $key
 * @param string $language
 *
 * @return string
 */
function _T($key, $language = null) {
    static $instance = null;
    /* @var $instance FLEA_Com_Language */
    if ($instance == null) {
        $instance = array();
        $obj =& get_singleton('FLEA_Com_Language');
        $instance = array('obj' => & $obj);
    }
    return $instance['obj']->get($key, $language);
}

/**
 * ���������ֵ��ļ�
 *
 * @param string $dictname
 * @param string $language
 *
 * @return boolean
 */
function load_language($dictname, $language = null) {
    $obj =& get_singleton('FLEA_Com_Language');
    /* @var $obj FLEA_Com_Language */
    return $obj->load($dictname, $language);
}

/**
 * FLEA_Com_Language �ṩ������ת������
 *
 * @package I18N
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_Language
{
    /**
     * ���浱ǰ������ֵ�
     *
     * @var array
     */
    var $_dict = array();

    /**
     * ָʾ��Щ�����ļ��Ѿ�������
     *
     * @var array
     */
    var $_files_loaded = array();

    function FLEA_Com_Language() {
        log_message('Construction FLEA_Com_Language', 'debug');
        $autoload = get_app_inf('autoLoadLanguage');
        if (!is_array($autoload)) {
            $autoload = explode(',', $autoload);
        }
        foreach ($autoload as $load) {
            $load = trim($load);
            if ($load != '') {
                $this->load($load);
            }
        }
    }

    /**
     * ����ָ�����Ե��ֵ��ļ�
     *
     * ���е������ļ������ա�����/�ֵ���.php������ʽ��������Ӧ�ó�������
     * 'languageFilesDir' ָ����Ŀ¼�С�Ĭ�ϵı���Ŀ¼Ϊ FLEA/Languages��
     *
     * ���û��ָ�� $language ��������������Ӧ�ó������� 'defaultLanguage'
     * ָ��������Ŀ¼�µ��ļ���
     *
     * $language �� $dicname ������ֻ��ʹ�� 26 ����ĸ��10 ������
     * �� ��-������_�� ���š�����ΪȫСд��
     *
     * @param string $dictname �ֵ��������� 'fleaphp'��'rbac'
     * @param string $language ���ԣ����� 'english'��'chinese-gb2312'��'chinese-utf8'
     */
    function load($dictname, $language = null) {
        $dictnames = explode(',', $dictname);
        foreach ($dictnames as $dictname) {
            $dictname = trim($dictname);
            if ($dictname == '') { continue; }

            $dictname = preg_replace('/[^a-z0-9\-_]+/i', '', strtolower($dictname));
            $language = preg_replace('/[^a-z0-9\-_]+/i', '', strtolower($language));
            if ($language == null) {
                $language = get_app_inf('defaultLanguage');
                $default = true;
            } else {
                $default = false;
            }

            $filename = get_app_inf('languageFilesDir') . DS .
                $language . DS . $dictname . '.php';
            if (isset($this->_files_loaded[$filename])) { continue; }

            if (is_readable($filename)) {
                $dict = require($filename);
                $this->_files_loaded[$filename] = true;
                if (isset($this->_dict[$language])) {
                    $this->_dict[$language] = array_merge($this->_dict[$language], $dict);
                } else {
                    $this->_dict[$language] = $dict;
                }
                if ($default) {
                    $this->_dict[0] =& $this->_dict[$language];
                }
            }
        }
    }

    /**
     * ����ָ�����Ķ�Ӧ���Է��룬û���ҵ�����ʱ���ؼ�
     *
     * @param string $key
     * @param string $language ���ʡ�� $language �������򷵻�Ĭ�ϵķ���
     *
     * @return string
     */
    function get($key, $language = null) {
        if ($language == null) {
            $language = 0;
        }
        return isset($this->_dict[$language][$key]) ?
            $this->_dict[$language][$key] :
            $key;
    }
}
