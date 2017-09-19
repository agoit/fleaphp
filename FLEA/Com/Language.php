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
 * 定义 FLEA_Com_Language 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package I18N
 * @version $Id: Language.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * 调用 FLEA_Com_Language::get() 获取翻译
 *
 * 用法：
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
 * 载入语言字典文件
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
 * FLEA_Com_Language 提供了语言转换功能
 *
 * @package I18N
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_Language
{
    /**
     * 保存当前载入的字典
     *
     * @var array
     */
    var $_dict = array();

    /**
     * 指示哪些语言文件已经被载入
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
     * 载入指定语言的字典文件
     *
     * 所有的语言文件均按照“语言/字典名.php”的形式保存在由应用程序设置
     * 'languageFilesDir' 指定的目录中。默认的保存目录为 FLEA/Languages。
     *
     * 如果没有指定 $language 参数，则载入由应用程序设置 'defaultLanguage'
     * 指定的语言目录下的文件。
     *
     * $language 和 $dicname 参数均只能使用 26 个字母、10 个数字
     * 和 “-”、“_” 符号。并且为全小写。
     *
     * @param string $dictname 字典名，例如 'fleaphp'、'rbac'
     * @param string $language 语言，例如 'english'、'chinese-gb2312'、'chinese-utf8'
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
     * 返回指定键的对应语言翻译，没有找到翻译时返回键
     *
     * @param string $key
     * @param string $language 如果省略 $language 参数，则返回默认的翻译
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
