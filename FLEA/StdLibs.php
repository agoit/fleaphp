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
 * �������������
 *
 * �����������Ϊ�����֣�
 *   - ���ĺ����⣺�����Ĺ�������
 *   - HTTP ��أ����ڴ��� HTTP �����Լ� URL ��ַ
 *   - ���������أ����������ת��������
 *   - �ļ�������������ʵ�õ��ļ�ϵͳ����
 *   - ���ݿ���أ��ṩ��ȡ���ݿ���ʶ���ı��������ͷ��� DSN �ַ�������
 *   - ���Ժʹ�������أ��ṩ�쳣ģ�⡢������������Ϣ����Ⱥ���
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: StdLibs.php 658 2006-12-27 14:41:32Z dualface $
 */

// {{{ ���ĺ���

/**
 * ע��Ӧ�ó�������
 *
 * Ӧ�ó�������ʵ������һ��ȫ�����飬FleaPHP ��Ӧ�ó���ͨ�� get_app_inf()
 * ����ȡ��ָ�������á����� get_app_inf('myAppOpt') ����ȡ����Ϊ myAppOpt
 * ������ֵ���� set_app_inf() ������޸�ָ�����õ�ֵ��
 *
 * ���� FleaPHP ��ܶ��ԣ�Ӧ�ó��������еĸ���ѡ��ȷ���� FleaPHP ������ģʽ�Լ���
 * ����ͬ���ʱӦ����η�Ӧ������Ӧ�ó�����ԣ����Խ�Ӧ�ó������õ���һ���������
 * ���õ����ݿ⣨������� Windows �û�����ô���Խ�Ӧ�ó�����������Ϊע�����
 *
 * Ŀǰ��FleaPHP ��ֱ��֧�ִ����ݿ���ȡ��Ӧ�ó������ã��������߿������б�ͨʵ�����
 * ���ܡ��� set_app_inf() �����ǵ����ĸı��ڴ��е�����ֵ�������Ὣ���ñ��浽�ļ�
 * �����ݿ⡣
 *
 * �÷���
 * <code>
 * $config = array('myAppOpt', 'opt_value');
 * register_app_inf($config);
 * // ���ߣ�
 * register_app_inf('myAppOpts.php');
 * </code>
 *
 * ���� register_app_inf() ���������ļ�ʱ�������ļ���Ӧ���� return ����һ�����顣
 * ���ص�����ᱻע��ΪӦ�ó������á�
 *
 * @param mixed $__config ��������������ļ���
 */
function register_app_inf($__flea_internal_config = null) {
    if (!is_array($__flea_internal_config) && is_string($__flea_internal_config)) {
        $__flea_internal_config = require($__flea_internal_config);
    }
    if (is_array($__flea_internal_config)) {
        $GLOBALS[G_FLEA_VAR]['APP_INF'] = array_merge(
            $GLOBALS[G_FLEA_VAR]['APP_INF'],
            $__flea_internal_config);
    }
}

/**
 * ȡ��ָ�����ֵ�����ֵ
 *
 * �÷���
 * <code>
 * $value = get_app_inf('myAppOpt');
 * </code>
 *
 * @param string $option
 *
 * @return mixed
 */
function get_app_inf($option) {
    return isset($GLOBALS[G_FLEA_VAR]['APP_INF'][$option]) ?
        $GLOBALS[G_FLEA_VAR]['APP_INF'][$option] :
        null;
}

/**
 * �޸�����ֵ
 *
 * �÷���
 * <code>
 * // �÷� 1���޸�ָ������ֵ
 * set_app_inf('myAppOpt', 'new_value');
 * // �÷� 2�������޸�����ֵ
 * $newConfig = array(
 *     'myAppOpt1' => 'new_value',
 *     'myAppOpt2' => 'new_value',
 * );
 * set_app_inf($newConfig);
 * </code>
 *
 * @param string $option
 * @param mixed $data
 */
function set_app_inf($option, $data = null) {
    if (is_array($option)) {
        $GLOBALS[G_FLEA_VAR]['APP_INF'] = array_merge(
            $GLOBALS[G_FLEA_VAR]['APP_INF'],
            $option);
    } else {
        $GLOBALS[G_FLEA_VAR]['APP_INF'][$option] = $data;
    }
}

/**
 * �����ļ�����·��
 *
 * �� FleaPHP �У��ඨ���ļ������� load_class() �������롣�ú��������������
 * ������·���������ҵ��ඨ���ļ���
 *
 * load_class() �ڳ��������ඨ���ļ�ʱ�������һ��·������������Ҫ���ļ������Ϊ��
 * �� load_class() �ܹ��ҵ���Ҫ���ļ�����ʱ��Ҫָ��һ������·����
 *
 * import() �����Ĺ��ܾ��ǽ�һ��·����ӵ�����·�������С�
 *
 * �й�Ŀ¼�ṹ�������������ϸ��Ϣ����ο� @see get_file_path() ������˵���� FleaPHP �û��ֲᡣ
 *
 * �÷���
 * <code>
 * import('/var/www/myapp/libs');
 * </code>
 *
 * @param string $dir
 */
function import($dir) {
    if (array_search($dir, $GLOBALS[G_FLEA_VAR]['CLASS_PATH'], true)) { return; }
    $GLOBALS[G_FLEA_VAR]['CLASS_PATH'][] = $dir;
}

/**
 * ����ָ�����ļ�
 *
 * �����������������ο� @see get_file_path()
 *
 * �÷���
 * <code>
 * // �����ļ� MYAPP/Helper/Image.php
 * load_file('MYAPP_Helper_Image.php');
 * </code>
 *
 * @param string $className
 * @param boolean $loadOnce ָ��Ϊ true ʱ��load_file() ��ͬ�� require_once
 *
 * @return boolean
 */
function load_file($filename, $loadOnce = false) {
    static $is_loaded = array();

    $path = get_file_path($filename);
    if ($path != '') {
        if (isset($is_loaded[$path]) && $loadOnce) { return true; }
        $is_loaded[$path] = true;
        return require($path);
    }

    load_class('FLEA_Exception_ExpectedFile');
    __THROW(new FLEA_Exception_ExpectedFile($filename));
    return false;
}

/**
 * ����ָ����Ķ����ļ�
 *
 * �ļ�������������ο� @see get_file_path()
 *
 * �÷���
 * <code>
 * load_class('FLEA_Helper_Pager');
 * $pager =& new FLEA_Helper_Pager(...);
 * </code>
 *
 * @param string $filename
 *
 * @return boolean
 */
function load_class($className) {
    if (class_exists($className)) { return true; }
    $filename = get_file_path($className . '.php');
    if ($filename) {
        require_once($filename);
        if (class_exists($className)) { return true; }
    }

    // �ļ���û��ָ����Ķ���
    require_once(FLEA_DIR . '/Exception/ExpectedClass.php');
    __THROW(new FLEA_Exception_ExpectedClass($className, $filename));
    return false;
}

/**
 * ���� FleaPHP ���������������ļ����ɹ������ļ�������·����ʧ�ܷ��� false
 *
 * �� FleaPHP �У�һ���Ƽ��������������ԡ�_�����ŷָ��д��ĸ��ͷ�ĵ��ʡ�
 * ���� HelloWorld Ӧ��дΪ Hello_World��ͬʱ����ʵ���ļ�����ʱ����_������Ӧ��
 * �滻ΪĿ¼�ָ�������� Hello_World ��ʵ�ʱ����ļ����ǣ�Hello/World.php
 *
 * ͬʱ�������ƺ��ඨ���ļ��Ķ�Ӧ��ϵҲ�ǰ�����������������
 * ���� FLEA_Db_TableDataGateway ��Ķ����ļ����� FLEA/Db/TableDataGateway.php��
 *
 * �� FleaPHP Ӧ�ó����У���Ȼ��ǿ��Ҫ������������������򣬵�����һ���Կ��Լ�Ӧ�ó���
 * ���ڵ�ά��������ʹ�ÿ����߸��������ƾ��ܺ����׵��ҵ��ඨ���ļ���
 *
 * ���ҿ��Ժܷ������ load_class() �������ඨ���ļ���
 * ������ load_file() ������һ���ļ����ඨ���ļ���
 *
 * �÷���
 * <code>
 * $fullpath = get_file_path('MyAPP_Helper_ShowMeTheMoney.php');
 * </code>
 *
 * @param string $filename
 *
 * @return string
 */
function get_file_path($filename) {
    $filename = str_replace('_', DIRECTORY_SEPARATOR, $filename);

    if (pathinfo($filename, PATHINFO_EXTENSION) == '') {
        $filename .= '.php';
    }

    // ����������ǰĿ¼
    if (is_readable($filename)) { return realpath($filename); }
    foreach ($GLOBALS[G_FLEA_VAR]['CLASS_PATH'] as $classdir) {
        $path = $classdir . DIRECTORY_SEPARATOR . $filename;
        if (is_readable($path)) { return $path; }
    }
    return false;
}

/**
 * ����ָ�������Ψһʵ��
 *
 * �ú�����һ��ͨ�õĵ������ģʽʵ�֡���ʹ��ͬ������������Ϊ����ʱ��
 * get_singleton() �᷵�ظ����ͬһ��ʵ�������ҵ��� @see reg() ����������
 * ע�ᵽ���������С�
 *
 * �� PHP �У����������£��ṩ����Ķ����������ݿ���ʡ�ҵ���߼�����ֻ��Ҫ
 * Ψһ��һ��ʵ����ʹ�øú��������Բ����Լ�ʵ�ֵ������ģʽ������˿���Ч�ʡ�
 *
 * ע�⣺�����Ĺ��캯��Ҫ���ṩ��������ô������ get_singleton() ����ȡ�����ʵ����
 *
 * �÷���
 * <code>
 * $obj =& get_singleton('MY_OBJ');
 * $obj2 =& get_singleton('MY_OBJ');
 * // ��ʱ $obj �� $obj2 ʵ����ָ��ͬһ�������ʵ��
 * </code>
 *
 * @param string $className
 *
 * @return object
 */
function & get_singleton($className) {
    if (check_reg($className)) { return ref($className); }
    if (!class_exists($className)) {
        if (!load_class($className)) {
            return false;
        }
    }

    $obj =& new $className();
    reg($obj, $className);
    return $obj;
}

/**
 * ��һ������ʵ��ע�ᵽ����ʵ������
 *
 * ���û��ָ�� $name ��������ʹ�ö����������
 * ���ָ�����ֵĶ����Ѿ����ڣ����׳� FLEA_Exception_ExistsKeyName �쳣��
 * reg() ע�����ɹ��󣬷��ظö�������á�
 *
 * �÷���
 * <code>
 * $obj =& new My_Object();
 * reg($obj, 'My_Object');
 * </code>
 *
 * @param object $obj
 * @param string $name
 *
 * @return object
 */
function & reg(& $obj, $name = null) {
    if (is_null($name) && is_object($obj)) {
        $name = get_class($obj);
    }

    if (isset($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name])) {
        load_class('FLEA_Exception_ExistsKeyName');
        __THROW(new FLEA_Exception_ExistsKeyName($name));
        return null;
    } else {
        $GLOBALS[G_FLEA_VAR]['OBJECTS'][$name] =& $obj;
        return $obj;
    }
}

/**
 * �Ӷ���ʵ��������ȡ��ָ�����ֵĶ���ʵ��
 *
 * ���û���ṩ $name �������򷵻����������е����ݡ�
 * ���ָ�����ֵĶ��󲻴��ڣ����׳� FLEA_Exception_NotExistsKeyName �쳣��
 *
 * �÷���
 * <code>
 * $obj =& ref('My_Object');
 * </code>
 *
 * @param string $name
 *
 * @return object
 */
function & ref($name = null) {
    if (is_null($name)) {
        return $GLOBALS[G_FLEA_VAR]['OBJECTS'];
    }
    if (isset($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name])) {
        return $GLOBALS[G_FLEA_VAR]['OBJECTS'][$name];
    }
    load_class('FLEA_Exception_NotExistsKeyName');
    __THROW(new FLEA_Exception_NotExistsKeyName($name));
    return null;
}

/**
 * ���ָ�����ֵĶ����Ƿ��Ѿ�ע��
 *
 * �÷���
 * <code>
 * if (check_reg('My_Object')) {
 *     $obj =& new My_Object();
 *     reg($obj, 'My_Object');
 * }
 * </code>
 *
 * @param string $name
 *
 * @return boolean
 */
function check_reg($name) {
    return isset($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name]);
}

/**
 * ��ȡָ����������ݣ�����������ݲ����ڻ�ʧЧ���򷵻� false
 *
 * �����ļ����Ǹ��� cacheId �� md5 �㷨���ɵġ��������ļ�����Ŀ¼����
 * Ӧ�ó������� internalCacheDir ������
 *
 * �� $timeIsLifetime ����Ϊ true ʱ���ú������黺���ļ������������ڼ���
 * $time �Ƿ���ڵ�ǰʱ�䡣����ǣ��򷵻� false����ʾ����������Ѿ����ڡ�
 *
 * ��� $timeIsLifetime ����Ϊ false����ú������黺���ļ��������������Ƿ����
 * $time ����ָ����ʱ�䡣����ǣ��򷵻� false��
 *
 * �÷���
 * <code>
 * // �÷� 1���������ݣ���������������Ϊ 900 ��
 * $cacheId = 'myDataCache';
 * $data = get_cache($cacheId, 900);
 * if (!$data) {
 *     // �����ݿ��ȡ����
 *     $data = $dbo->getAll($sql);
 *     write_cache($cacheId, $data);
 * }
 *
 * // �÷� 2��
 * $xmlFilename = 'myData.xml';
 * $xmlData = get_cache($xmlFilename, filemtime($xmlFilename), false);
 * if (!$xmlData) {
 *     $xmlData = ����xml();
 *     write_cache($xmlFilename, $xmlData);
 * }
 * </code>
 *
 * @param string $cacheId ����ID����ͬ�Ļ�������Ӧ��ʹ�ò�ͬ��ID
 * @param int $time �������ʱ��򻺴���������
 * @param boolean $timeIsLifetime ָʾ $time ����������
 *
 * @return mixed ���ػ�������ݣ����治���ڻ�ʧЧ�򷵻� false
 */
function get_cache($cacheId, $time = 900, $timeIsLifetime = true) {
    $cacheFile = get_app_inf('internalCacheDir') . DS . md5($cacheId) . '.php';
    if (!is_readable($cacheFile)) { return false; }
    $filetime = filemtime($cacheFile);
    if ($timeIsLifetime) {
        if (time() >= $filetime + $time) { return false; }
    } else {
        if ($time >= $filetime) { return false; }
    }
    return require($cacheFile);
}

/**
 * ����������д�뻺��
 *
 * �÷���
 * <code>
 * write_cache('my_cache_id', $data);
 * </code>
 *
 * @param string $cacheId
 * @param mixed $data
 *
 * @return boolean
 */
function write_cache($cacheId, $data) {
    $cacheFile = get_app_inf('internalCacheDir') . DS . md5($cacheId) . '.php';
    $contents = '<?php return ' . var_export($data, true) . '; ?>';
    return file_put_contents($cacheFile, $contents);
}

/**
 * ɾ��ָ���Ļ�������
 *
 * �÷���
 * <code>
 * purge_cache('my_cache_id');
 * </code>
 *
 * @param string $cacheId
 */
function purge_cache($cacheId) {
    $cacheFile = get_app_inf('internalCacheDir') . DS . md5($cacheId) . '.php';
    if (file_exists($cacheFile)) { unlink($cacheFile); }
}

/**
 * ���� YAML��ͨ����չ��Ϊ .yml.php�� �ļ������ݣ����ط������
 *
 * load_yaml() ���Զ�ʹ�û��棬ֻ�е� YAML �ļ����ı�󣬻���Ż���¡�
 *
 * ���� YAML ����ϸ��Ϣ,��ο� www.yaml.org ��
 *
 * �÷���
 * <code>
 * $data = load_yaml('myData.yaml');
 * </code>
 *
 * ע�⣺Ϊ�˰�ȫ�������Ҫʹ�� YAML �洢������Ϣ���������롣���߽� YAML �ļ���
 * ��չ������Ϊ .yml.php��������ÿһ�� YAML �ļ���ͷ���� # <?php exit(); ?>��
 * <code>
 * # <?php exit(); ?>
 *
 * invoice: 34843
 * date   : 2001-01-23
 * bill-to: &id001
 * ......
 * </code>
 *
 * ��������ȷ�����������ֱ�ӷ��ʸ� .yml.php �ļ���Ҳ�޷��������ݡ�
 *
 * @param string $filename
 * @param boolean $cacheEnabled �Ƿ񻺴��������
 *
 * @return array
 */
function load_yaml($filename, $cacheEnabled = true) {
    if ($cacheEnabled) {
        $arr = get_cache($filename, filemtime($filename), false);
        if ($arr) { return $arr; }
    }

    load_file('FLEA_Helper_Spyc.php', true);
    $spyc =& get_singleton('Spyc');

    $arr = $spyc->load($filename);
    if ($cacheEnabled) {
        write_cache($filename, $arr);
    }
    return $arr;
}

// }}}

// {{{ HTTP ���

/**
 * �ض����������ָ���� URL
 *
 * �÷���
 * <code>
 * redirect($url, 5);
 * </code>
 *
 * @param string $url Ҫ�ض���� url
 * @param int $delay �ȴ��������Ժ���ת
 */
function redirect($url, $delay = 0) {
    if (headers_sent() || $delay > 0) {
        $delay = (int)$delay;
        echo <<<EOT
<html>
<head>
<meta http-equiv="refresh" content="{$delay};URL={$url}" />
</head>
</html>
EOT;
    } else {
        header("Location: {$url}");
    }
    exit;
}

/**
 * ���� url
 *
 * ���� url ��Ҫ�ṩ�������������������ƺͿ����������������ʡ��������������������һ����
 * �� url() ������ʹ��Ӧ�ó��������е�ȷ����Ĭ�Ͽ������ƺ�Ĭ�Ͽ�������������
 *
 * $mode �����֣�
 *   URL_STANDARD - ��׼ģʽ��Ĭ�ϣ������� index.php?url=Login&action=Reject&id=1
 *   URL_PATHINFO - PATHINFO ģʽ������ index.php/Login/Reject/id/1
 *   URL_REWRITE  - URL ��дģʽ������ /Login/Reject/id/1
 *
 * ���ɵ� url ��ַ����Ҫ������Ӧ�ó������õ�Ӱ�죺
 *   - controllerAccessor
 *   - defaultController
 *   - actionAccessor
 *   - defaultAction
 *   - urlMode
 *   - urlLowerChar
 *
 * �÷���
 * <code>
 * $url = url('Login', 'checkUser');
 * // $url ����Ϊ ?controller=Login&action=checkUser
 *
 * $url = url('Login', 'checkUser', array('username' => 'dualface');
 * // $url ����Ϊ ?controller=Login&action=checkUser&username=dualface
 * </code>
 *
 * @param string $controllerName
 * @param string $actionName
 * @param array $params
 * @param string $mode
 *
 * @return string
 */
function url($controllerName = null, $actionName = null, $params = null, $mode = null) {
    if ($controllerName == null) {
        $controllerName = get_app_inf('defaultController');
    }
    if ($actionName == null) {
        $actionName = get_app_inf('defaultAction');
    }

    if (get_app_inf('urlLowerChar')) {
        $controllerName = strtolower($controllerName);
        $actionName = strtolower($actionName);
    }

    if (!$mode) {
        $mode = get_app_inf('urlMode');
    }

    $url = '';
    switch($mode) {
    case URL_PATHINFO:
    case URL_REWRITE:
        // PATHINFO �� REWRITE ģʽ
        if ($mode == URL_PATHINFO) {
            $url .= $_SERVER['SCRIPT_NAME'];
        } else {
            $url .= dirname($_SERVER['SCRIPT_NAME']);
        }
        $url .= '/' . rawurlencode($controllerName) . '/' . rawurlencode($actionName);
        if (is_array($params)) {
            $url .= '/';
            foreach ($params as $key => $value) {
                $url .= rawurlencode($key) . '/' . rawurlencode($value) . '/';
            }
            $url = substr($url, 0, -1);
        }
        return $url;
    }

    // ��׼ģʽ
    $url = $_SERVER['SCRIPT_NAME'];
    $url .= '?' . get_app_inf('controllerAccessor'). '=' . rawurlencode($controllerName);
    $url .= '&' . get_app_inf('actionAccessor') . '=' . rawurlencode($actionName);
    if (is_array($params) && !empty($params)) {
        $url .= '&' . encode_url_args($params);
    }
    return $url;
}

/**
 * ������ת��Ϊ��ͨ�� url ���ݵ��ַ�������
 *
 * �÷���
 * <code>
 * $string = encode_url_args(array('username' => 'dualface', 'mode' => 'md5'));
 * // $string ����Ϊ username=dualface&mode=md5
 * </code>
 *
 * @param array $args
 *
 * @return string
 */
function encode_url_args($args) {
    $str = '';
    foreach ($args as $key => $value) {
        $str .= '&' . rawurlencode($key) . '=' . rawurlencode($value);
    }
    return substr($str, 1);
}

// }}}

// {{{ ����������

/**
 * ת�� HTML �����ַ�����ͬ�� htmlspecialchars()
 *
 * @param string $text
 *
 * @return string
 */
function h($text) {
    return htmlspecialchars($text);
}

/**
 * ת�� HTML �����ַ��Լ��ո�ͻ��з�
 *
 * �ո��滻Ϊ &nbsp; �����з��滻Ϊ <br />��
 *
 * @param string $text
 *
 * @return string
 */
function t($text) {
    return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($text)));
}

/**
 * ���ת�� HTML �����ַ�����ı�����ͬ�� echo h($text);
 *
 * @param string $text
 */
function echo_h($text) {
    echo htmlspecialchars($text);
}

/**
 * ���ת�� HTML �����ַ����ո�ͻ��з�����ı�����ͬ�� echo t($text)
 *
 * @param string $text
 */
function echo_t($text) {
    echo t($text);
}

/**
 * ͨ�� JavaScript �ű���ʾ��ʾ�Ի��򣬲��رմ��ڻ����ض��������
 *
 * �÷���
 * <code>
 * js_alert('Dialog message', '', $url);
 * // ����
 * js_alert('Dialog message', 'window.close();');
 * </code>
 *
 * @param string $message Ҫ��ʾ����Ϣ
 * @param string $after_action ��ʾ��Ϣ��Ҫִ�еĶ���
 * @param string $url �ض���λ��
 */
function js_alert($message = '', $after_action = '', $url = '') {
    $out = "<script language=\"javascript\" type=\"text/javascript\">\n";
    if (!empty($message)) {
        $out .= "alert(\"";
        $out .= str_replace("\\\\n", "\\n", t2js(addslashes($message)));
        $out .= "\");\n";
    }
    if (!empty($after_action)) {
        $out .= $after_action . "\n";
    }
    if (!empty($url)) {
        $out .= "document.location.href=\"";
        $out .= $url;
        $out .= "\";\n";
    }
    $out .= "</script>";
    echo $out;
    exit;
}

/**
 * �������ַ���ת��Ϊ JavaScript �ַ�������������β��"��
 *
 * @param string $content
 *
 * @return string
 */
function t2js($content) {
    return str_replace("\n", "\\n", addslashes($content));
}

// }}}

// {{{ �ļ�������
if (!function_exists('file_put_contents')) {
    /**
     * file_put_contents() һ������ɴ��ļ���д�����ݣ��ر��ļ������
     *
     * @param string $filename
     * @param string $content
     *
     * @return boolean
     */
    function file_put_contents($filename, & $content) {
        $fp = fopen($filename, 'w');
        if (!$fp) { return false; }
        if (!flock($fp, LOCK_EX)) {
            fclose($fp);
            return false;
        }
        fwrite($fp, $content);
        fclose($fp);
        return true;
    }
}

/**
 * ����һ��Ŀ¼��
 *
 * �÷���
 * <code>
 * mkdirs('/top/second/3rd');`
 * </code>
 *
 * @param string $dir
 * @param int $mode
 */
function mkdirs($dir, $mode = 0777) {
    if (!is_dir($dir)) {
        mkdirs(dirname($dir), $mode);
        return mkdir($dir, $mode);
    }
    return true;
}

/**
 * ɾ��ָ��Ŀ¼�����µ������ļ�����Ŀ¼
 *
 * �÷���
 * <code>
 * // ɾ�� my_dir Ŀ¼�����µ������ļ�����Ŀ¼
 * rmdirs('/path/to/my_dir');
 * </code>
 *
 * ע�⣺ʹ�øú���Ҫ�ǳ��ǳ�С�ģ���������ɾ����Ҫ�ļ���
 *
 * @param string $dir
 */
function rmdirs($dir) {
    $dir = realpath($dir);
    if ($dir == '' || $dir == '/' ||
        (strlen($dir) == 3 && substr($dir, 1) == ':\\'))
    {
        // ��ֹɾ����Ŀ¼
        return false;
    }

    // ����Ŀ¼��ɾ�������ļ�����Ŀ¼
    if(false !== ($dh = opendir($dir))) {
        while(false !== ($file = readdir($dh))) {
            if($file == '.' || $file == '..') { continue; }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                if (!rmdirs($path)) { return false; }
            } else {
                unlink($path);
            }
        }
        closedir($dh);
        rmdir($dir);
        return true;
    } else {
        return false;
    }
}

// }}}

// {{{ ���ݿ����

/**
 * �������ݿ���ʶ���ʵ��
 *
 * $dsn ����ʵ������һ�����ݿ�����������Ϣ���飬��Ҫ��������ֵ��
 *   - driver ���ݿ��������ͣ����� mysql��pgsql �ȣ�
 *   - host ���ݿ����ڷ�������ͨ��Ϊ localhost �� 127.0.0.1
 *   - port �������ݿ�Ķ˿ڣ�ͨ������ָ��
 *   - login ����ʱʹ�õ��û���
 *   - password ����ʱʹ�õ�����
 *   - database ���Ӻ�Ҫʹ�õ����ݿ���
 *   - charset �ַ������ã����û�����ø�ѡ�����Ӧ�ó������� databaseCharset Ϊ׼
 *   - options ���ӵ�����ѡ��
 *
 * ֻ�е��ṩ�� $dsn ������ͬʱ��get_dbo() �Ż᷵�ز�ͬ�� SDBO ����ʵ����
 *
 * ����Ѿ����ù� get_dbo()�����ɹ���������ݿ���ʶ���ʵ������ô������ get_dbo(false)
 * ���Ĭ�ϵ����ݿ���ʶ���ʵ����
 *
 * �÷���
 * <code>
 * $dsn = array(...);
 * $dbo =& get_dbo($dsn);
 * </code>
 *
 * @param array $dsn
 *
 * @return SDBO
 */
function & get_dbo($dsn) {
    static $instances = array();

    if (!is_array($dsn)) {
        if ($dsn === false) {
            if (count($instances)) {
                reset($instances);
                $offset = key($instances);
                return $instances[$offset];
            }
        }
        $dsn = parse_dsn($dsn);
        if (!is_array($dsn)) {
            load_class('FLEA_Db_Exception_InvalidDSN');
            __THROW(new FLEA_Db_Exception_InvalidDSN($dsn));
            return null;
        }
    }
    $id = md5(serialize($dsn));

    if (isset($instances[$id])) {
        return $instances[$id];
    }

    $driverClass = 'FLEA_Db_Driver_' . ucfirst(strtolower(basename($dsn['driver'])));
    load_class($driverClass);
    $instances[$id] =& new $driverClass($dsn);
    return $instances[$id];
}

/**
 * ���� DSN �ַ��������ذ��� DSN ������Ϣ�����飬ʧ�ܷ��� false
 *
 * DSN �ַ�����������ĸ�ʽ��
 * driver://login:password@host/database/options
 * ���� DSN �ַ�����ÿһ���ֵ���ϸ���ͣ���ο� @see get_dbo()��
 *
 * �÷���
 * <code>
 * $string = 'mysql://root:123456@localhost/test';
 * $dsn = parse_dsn($string);
 * </code>
 *
 * @param string $dsnString
 *
 * @return array
 */
function parse_dsn($dsnString) {
    $dsnString = str_replace('@/', '@localhost/', $dsnString);
    $parse = parse_url($dsnString);
    if (empty($parse['scheme'])) { return false; }

    $dsn = array();
    $dsn['host']     = isset($parse['host']) ? $parse['host'] : 'localhost';
    $dsn['port']     = isset($parse['port']) ? $parse['port'] : '';
    $dsn['login']    = isset($parse['user']) ? $parse['user'] : '';
    $dsn['password'] = isset($parse['pass']) ? $parse['pass'] : '';
    $dsn['driver']   = isset($parse['scheme']) ? strtolower($parse['scheme']) : '';
    $dsn['database'] = isset($parse['path']) ? substr($parse['path'], 1) : '';
    $dsn['options']  = isset($parse['query']) ? $parse['query'] : '';
    return $dsn;
}

// }}}

// {{{ ���Ժʹ��������

/**
 * �׳�һ���쳣
 *
 * FleaPHP Ϊ�˼��� PHP4��ģ����һ���쳣���ơ�������ģ����ƺ��������쳣�����б�������
 * FleaPHP ģ����쳣�����������ص㣺
 *   - �� __TRY() ������ try ���ò���㣻
 *   - �� __CATCH() �����쳣�������� catch��
 *   - �� __THROW() �׳��쳣��
 *   - __TRY() �� __CATCH() �����ܹ����� PHP5 ���� throw �׳����쳣��
 *   - ������ʹ�� __THROW() �׳��쳣�󣬱���ʹ�� return false �˳��������෽����ִ�У�
 *   - __TRY() �� __CATCH() ����ɶԵ��ã����� __CATCH() ֻ�ܲ���һ���쳣��
 *   - �� __IS_EXCEPTION() ���ж� __CATCH() �ķ���ֵ�Ƿ���һ���쳣��
 *   - ��� __TRY() ���ú�û���� __CATCH() �����쳣�������� __CANCEL_TRY() ȡ������
 *
 * ��Ȼ __THROW() ����ǿ��Ҫ���׳����쳣�����Ǵ� FLEA_Exception �̳е��࣬��Ӧ�ó���
 * Ӧ���׳� FleaPHP �Ѿ�������쳣�����ߴ� FLEA_Exception ����Ӧ�ó����Լ����쳣��
 * FLEA_Exception �ṩ��һЩ������������Ӧ�ó�����õĴ����쳣��
 *
 * ����Ĵ���Ƭ����ģ���쳣�����ʹ����ʽ��
 * <code>
 * __TRY();
 * $ret = doSomething(); // ���ÿ��ܻᷢ���쳣�Ĵ���
 * $ex = __CATCH();
 * if (__IS_EXCEPTION($ex)) {
 *     // �����쳣
 * } else {
 *     echo $ret;
 * }
 *
 * function doSomething() {
 *     if (rand(0, 9) % 2) {
 *         __THROW(new MyException());
 *         return false;
 *     }
 *     return true;
 * }
 * </code>
 *
 * <strong>�ر�Ҫע��ľ���ʹ�� __THROW() �׳��쳣�󣬱��� return false</strong>
 *
 * ���� doSomething() �е� __THROW() ʵ���ϲ����жϳ���ִ�У����Ե��� doSomething() ��
 * ����Ҫ�����鷵��ֵ�������ڵ��� doSomething() �Ժ���Ⲷ���쳣��
 *
 * Ϊ�ˣ�__TRY() �� __CATCH() ֮��Ĵ���Ҫ�����ܵ��١�
 *
 * <strong>���� __TRY() �� __CATCH() ��Ƕ�����⣺</strong>
 *
 * FleaPHP ������ __TRY() Ƕ�׵ġ���������������У�doSomething() �������������������׳�
 * �쳣�Ĵ��롣���� doSomething() ��Ҳ����ͨ�� __TRY() �� __CATCH() �������쳣��
 *
 * <code>
 * function doSomething() {
 *     if (rand(0, 9) % 2) {
 *         __THROW(new MyException());
 *         return false;
 *     } else {
 *         __TRY();
 *         callAnotherFunc();
 *         $ex = __CATCH();
 *         if (__IS_EXCEPTION($ex)) {
 *             // ���� callAnotherFunc() �����׳����쳣
 *             ...
 *             // ���ݴ������������� __THROW() �����׳�����쳣��
 *             // �õ��� doSomething() �Ĵ���ȥ������쳣
 *             __THROW($ex);
 *             return false;
 *         }
 *         return true;
 *     }
 * }
 * </code>
 *
 * ������� __TRY() ֮����Ҫ���� __CATCH() �����쳣��������� __CANCEL_TRY()
 * ������ __TRY() ���õĲ���㡣
 *
 * @param FLEA_Exception $exception
 */
function __THROW($exception) {
    // д����־
    if (function_exists('log_message')) {
        log_message(get_class($exception) . ': ' . $exception->getMessage(), 'exception');
    }

    // ȷ���Ƿ��쳣������ջ��
    if (isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']) &&
        is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']))
    {
        $point = array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
        if ($point != null) {
            array_push($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'], $exception);
            return;
        }
    }

    if (isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'])) {
        call_user_func_array(
            $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'],
            array(& $exception));
        exit;
    } else {
        print_ex($exception);
        exit;
    }
}

/**
 * �����쳣���ص�
 */
function __TRY() {
    static $point = 0;
    if (!isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']) ||
        !is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']))
    {
        $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'] = array();
    }

    $point++;
    array_push($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'], $point);
}

/**
 * �����׳����쳣�����û���쳣�׳������� false
 *
 * @return FLEA_Exception
 */
function __CATCH() {
    if (!is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'])) {
        return false;
    }
    $exception = array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
    if (!is_object($exception)) {
        $exception = false;
    }
    return $exception;
}

/**
 * ������һ�� __TRY() �쳣��������
 */
function __CANCEL_TRY() {
    if (is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'])) {
        array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
    }
}

/**
 * �ж��Ƿ���һ���쳣
 *
 * @param FLEA_Exception $exception
 */
function __IS_EXCEPTION($exception) {
    if (!is_object($exception) || !is_a($exception, 'FLEA_Exception')) {
        return false;
    }
    return true;
}

/**
 * �����µ��쳣�������̣����ص�ǰʹ�õ��쳣��������
 *
 * ���׳����쳣û���κ� __TRY() ����ʱ���������쳣�������̡�FleaPHP Ĭ�ϵ�
 * �쳣�������̻���ʾ�쳣����ϸ��Ϣ���Ѿ���������·�������������߶�λ����
 *
 * �÷���
 * <code>
 * // ��������ʹ�õ��쳣��������
 * global $prevExceptionHandler;
 * $prevExceptionHandler = __SET_EXCEPTION_HANDLER('app_exception_handler');
 *
 * function app_exception_handler(& $ex) {
 *     global $prevExceptionHandler;
 *
 *     if (is_a($ex, 'APP_Exception')) {
 *        // ������쳣
 *        ...
 *     } else {
 *        // ����ԭ�е��쳣��������
 *        if ($prevExceptionHandler) {
 *            call_user_func_array($prevExceptionHandler, array(& $exception));
 *        }
 *     }
 * }
 * </code>
 *
 * ����Ĵ���������һ���µ��쳣�������̣�ͬʱ�����ڱ�Ҫʱ����ԭ�е��쳣�������̡�
 * ��Ȼ��ǿ��Ҫ�󿪷���������������������Ĵ���Ƭ�ο����γ�һ���쳣�������̵�������
 *
 * @param callback $callback
 *
 * @return mixed
 */
function __SET_EXCEPTION_HANDLER($callback) {
    if (isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'])) {
        $current = $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'];
    } else {
        $current = null;
    }
    $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'] = $callback;
    return $current;
}

/**
 * FleaPHP Ĭ�ϵ��쳣��������
 *
 * @param FLEA_Exception $ex
 */
function __FLEA_EXCEPTION_HANDLER($ex) {
    print_ex($ex);
}

/**
 * ��ӡ�쳣����ϸ��Ϣ
 *
 * @param FLEA_Exception $ex
 * @param boolean $return Ϊ true ʱ���������Ϣ��������ֱ����ʾ
 */
function print_ex($ex, $return = false) {
    $out = "exception '" . get_class($ex) . "'";
    if ($ex->getMessage() != '') {
        $out .= " with message '" . $ex->getMessage() . "'";
    }
    $out .= ' in ' . $ex->getFile() . ':' . $ex->getLine() . "\n\n";
    $out .= $ex->getTraceAsString();

    if ($return) { return $out; }

    if (ini_get('html_errors')) {
        echo nl2br(htmlspecialchars($out));
    } else {
        echo $out;
    }

    return '';
}

/**
 * ������������ݣ�ͨ�����ڵ���
 *
 * @param mixed $vars Ҫ����ı���
 * @param string $label
 * @param boolean $return
 */
function dump($vars, $label = '', $return = false) {
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}

/**
 * ��ʾӦ�ó���ִ��·����ͨ�����ڵ���
 *
 * @return string
 */
function dump_trace() {
    $debug = debug_backtrace();
    $lines = '';
    $index = 0;
    for ($i = 0; $i < count($debug); $i++) {
        if ($i == 0) { continue; }
        $file = $debug[$i];
        if ($file['file'] == '') { continue; }
        if (substr($file['file'], 0, strlen(FLEA_DIR)) != FLEA_DIR) {
            $line = "#<strong>{$index} {$file['file']}({$file['line']}): </strong>";
        } else {
            $line = "#{$index} {$file['file']}({$file['line']}): ";
        }
        if (isset($file['class'])) {
            $line .= "{$file['class']}{$file['type']}";
        }
        $line .= "{$file['function']}(";
        if (isset($file['args']) && count($file['args'])) {
            foreach ($file['args'] as $arg) {
                $line .= gettype($arg) . ', ';
            }
            $line = substr($line, 0, -2);
        }
        $line .= ')';
        $lines .= $line . "\n";
        $index++;
    } // for
    $lines .= "#{$index} {main}\n";

    if (ini_get('html_errors')) {
        echo nl2br(str_replace(' ', '&nbsp;', $lines));
    } else {
        echo $lines;
    }
}

/**
 * ��ʾϵͳ������Ϣ�����жϳ�������
 *
 * @param string $name
 */
function throw_error($name) {
    $msg = "throw_error({$name}):\n\n";
    if (ini_get('html_errors')) {
        echo nl2br(htmlspecialchars($msg));
    } else {
        echo $msg;
    }
    dump_trace();
    echo "<hr>\nArguments:<br>\n";
    echo_t(print_r($argv, true));
    exit;
}

/**
 * ��ѯָ��������Ϣ��Ӧ����Ϣ�ı�
 *
 * �ú��������Ӧ�ó������� 'defaultLanguage' ���벻ͬ���ԵĴ�����Ϣ�ļ���
 * Ȼ����ݴ�������ѯ������Ϣ�ı��������ز�ѯ�����
 *
 * ע�⣬����Ҳ���ָ�����ԵĴ�����Ϣ����������Ϊ default �������ļ���
 *
 * �� $appError Ϊ true ʱ��_E() �᳢����Ӧ�ó�������
 * 'languageFilesDir' ָ����Ŀ¼�ж�ȡ�����ļ���
 *
 * @param int $errorCode
 * @param boolean $appError
 *
 * @return string
 */
function _E($errorCode, $appError = false) {
    static $message = array();

    $language = get_app_inf('defaultLanguage');
    if (!isset($message[$language])) {
        if ($appError) {
            $filename = get_app_inf('languageFilesDir') . DS .
                $language . DS . 'ErrorMessage.php';
        } else {
            // ��ȡ FleaPHP �Դ��Ĵ�����Ϣ�б�
            $filename = FLEA_DIR . DS . 'Languages' . DS .
                $language . DS . 'ErrorMessage.php';
        }
        if (!is_readable($filename)) {
            $filename = FLEA_DIR . DS . 'Languages' . DS .
                'default' . DS . 'ErrorMessage.php';
        }
        $message[$language] = include($filename);
    }

    return isset($message[$language][$errorCode]) ?
        $message[$language][$errorCode] :
        '';
}

// }}}
