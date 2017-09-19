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
 * 定义基本函数库
 *
 * 基本函数库分为几部分：
 *   - 核心函数库：基本的公共函数
 *   - HTTP 相关：用于处理 HTTP 请求以及 URL 地址
 *   - 输入输出相关：分析输入和转换输出结果
 *   - 文件处理函数：几个实用的文件系统函数
 *   - 数据库相关：提供获取数据库访问对象的便利方法和分析 DSN 字符串功能
 *   - 调试和错误处理相关：提供异常模拟、错误处理、调试信息输出等函数
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: StdLibs.php 658 2006-12-27 14:41:32Z dualface $
 */

// {{{ 核心函数

/**
 * 注册应用程序设置
 *
 * 应用程序设置实际上是一个全局数组，FleaPHP 和应用程序都通过 get_app_inf()
 * 函数取出指定的设置。例如 get_app_inf('myAppOpt') 可以取出名为 myAppOpt
 * 的设置值。而 set_app_inf() 则可以修改指定设置的值。
 *
 * 对于 FleaPHP 框架而言，应用程序设置中的各种选项确定了 FleaPHP 的运行模式以及在
 * 处理不同情况时应该如何反应。对于应用程序而言，可以将应用程序设置当作一个保存各种
 * 设置的数据库（如果你是 Windows 用户，那么可以将应用程序设置想象为注册表）。
 *
 * 目前，FleaPHP 不直接支持从数据库中取出应用程序设置，但开发者可以自行变通实现这个
 * 功能。而 set_app_inf() 仅仅是单纯的改变内存中的设置值，并不会将设置保存到文件
 * 或数据库。
 *
 * 用法：
 * <code>
 * $config = array('myAppOpt', 'opt_value');
 * register_app_inf($config);
 * // 或者：
 * register_app_inf('myAppOpts.php');
 * </code>
 *
 * 当用 register_app_inf() 载入配置文件时，配置文件中应该用 return 返回一个数组。
 * 返回的数组会被注册为应用程序设置。
 *
 * @param mixed $__config 配置数组或配置文件名
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
 * 取出指定名字的设置值
 *
 * 用法：
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
 * 修改设置值
 *
 * 用法：
 * <code>
 * // 用法 1：修改指定设置值
 * set_app_inf('myAppOpt', 'new_value');
 * // 用法 2：批量修改设置值
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
 * 增加文件搜索路径
 *
 * 在 FleaPHP 中，类定义文件可以用 load_class() 函数载入。该函数会根据类名称
 * 和搜索路径，尝试找到类定义文件。
 *
 * load_class() 在尝试搜索类定义文件时，会根据一个路径数组搜索需要的文件。因此为了
 * 让 load_class() 能够找到需要的文件，有时需要指定一个搜索路径。
 *
 * import() 函数的功能就是将一个路径添加到搜索路径数组中。
 *
 * 有关目录结构和命名规则的详细信息，请参考 @see get_file_path() 函数的说明和 FleaPHP 用户手册。
 *
 * 用法：
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
 * 载入指定的文件
 *
 * 关于类的命名规则请参考 @see get_file_path()
 *
 * 用法：
 * <code>
 * // 载入文件 MYAPP/Helper/Image.php
 * load_file('MYAPP_Helper_Image.php');
 * </code>
 *
 * @param string $className
 * @param boolean $loadOnce 指定为 true 时，load_file() 等同于 require_once
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
 * 载入指定类的定义文件
 *
 * 文件的命名规则请参考 @see get_file_path()
 *
 * 用法：
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

    // 文件中没有指定类的定义
    require_once(FLEA_DIR . '/Exception/ExpectedClass.php');
    __THROW(new FLEA_Exception_ExpectedClass($className, $filename));
    return false;
}

/**
 * 按照 FleaPHP 中命名规则，搜索文件。成功返回文件的完整路径，失败返回 false
 *
 * 在 FleaPHP 中，一种推荐的命名规则是以“_”符号分割大写字母开头的单词。
 * 例如 HelloWorld 应该写为 Hello_World。同时，在实际文件保存时，“_”符号应该
 * 替换为目录分隔符。因此 Hello_World 的实际保存文件就是：Hello/World.php
 *
 * 同时，类名称和类定义文件的对应关系也是按照上述规则命名。
 * 例如 FLEA_Db_TableDataGateway 类的定义文件就是 FLEA/Db/TableDataGateway.php。
 *
 * 在 FleaPHP 应用程序中，虽然不强制要求采用这样的命名规则，但保持一致性可以简化应用程序
 * 后期的维护，并且使得开发者根据类名称就能很容易的找到类定义文件。
 *
 * 而且可以很方便的用 load_class() 来载入类定义文件，
 * 或者用 load_file() 来载入一般文件或类定义文件。
 *
 * 用法：
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

    // 首先搜索当前目录
    if (is_readable($filename)) { return realpath($filename); }
    foreach ($GLOBALS[G_FLEA_VAR]['CLASS_PATH'] as $classdir) {
        $path = $classdir . DIRECTORY_SEPARATOR . $filename;
        if (is_readable($path)) { return $path; }
    }
    return false;
}

/**
 * 返回指定对象的唯一实例
 *
 * 该函数是一个通用的单子设计模式实现。当使用同样的类名称作为参数时，
 * get_singleton() 会返回该类的同一个实例。并且调用 @see reg() 函数将对象
 * 注册到对象容器中。
 *
 * 在 PHP 中，大多数情况下，提供服务的对象（例如数据库访问、业务逻辑）都只需要
 * 唯一的一个实例。使用该函数，可以不用自己实现单子设计模式，提高了开发效率。
 *
 * 注意：如果类的构造函数要求提供参数，那么不能用 get_singleton() 来获取该类的实例。
 *
 * 用法：
 * <code>
 * $obj =& get_singleton('MY_OBJ');
 * $obj2 =& get_singleton('MY_OBJ');
 * // 此时 $obj 和 $obj2 实际上指向同一个对象的实例
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
 * 将一个对象实例注册到对象实例容器
 *
 * 如果没有指定 $name 参数，则使用对象的类名。
 * 如果指定名字的对象已经存在，则抛出 FLEA_Exception_ExistsKeyName 异常。
 * reg() 注册对象成功后，返回该对象的引用。
 *
 * 用法：
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
 * 从对象实例容其中取出指定名字的对象实例
 *
 * 如果没有提供 $name 参数，则返回整个容器中的内容。
 * 如果指定名字的对象不存在，则抛出 FLEA_Exception_NotExistsKeyName 异常。
 *
 * 用法：
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
 * 检查指定名字的对象是否已经注册
 *
 * 用法：
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
 * 读取指定缓存的内容，如果缓存内容不存在或失效，则返回 false
 *
 * 缓存文件名是根据 cacheId 用 md5 算法生成的。而缓存文件保存目录则由
 * 应用程序设置 internalCacheDir 决定。
 *
 * 当 $timeIsLifetime 参数为 true 时，该函数会检查缓存文件的最后更新日期加上
 * $time 是否大于当前时间。如果是，则返回 false，表示缓存的内容已经过期。
 *
 * 如果 $timeIsLifetime 参数为 false，则该函数会检查缓存文件的最后更新日期是否大于
 * $time 参数指定的时间。如果是，则返回 false。
 *
 * 用法：
 * <code>
 * // 用法 1：缓存数据，缓存数据生存期为 900 秒
 * $cacheId = 'myDataCache';
 * $data = get_cache($cacheId, 900);
 * if (!$data) {
 *     // 从数据库读取数据
 *     $data = $dbo->getAll($sql);
 *     write_cache($cacheId, $data);
 * }
 *
 * // 用法 2：
 * $xmlFilename = 'myData.xml';
 * $xmlData = get_cache($xmlFilename, filemtime($xmlFilename), false);
 * if (!$xmlData) {
 *     $xmlData = 分析xml();
 *     write_cache($xmlFilename, $xmlData);
 * }
 * </code>
 *
 * @param string $cacheId 缓存ID，不同的缓存内容应该使用不同的ID
 * @param int $time 缓存过期时间或缓存生存周期
 * @param boolean $timeIsLifetime 指示 $time 参数的作用
 *
 * @return mixed 返回缓存的内容，缓存不存在或失效则返回 false
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
 * 将变量内容写入缓存
 *
 * 用法：
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
 * 删除指定的缓存内容
 *
 * 用法：
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
 * 载入 YAML（通常扩展名为 .yml.php） 文件的内容，返回分析结果
 *
 * load_yaml() 会自动使用缓存，只有当 YAML 文件被改变后，缓存才会更新。
 *
 * 关于 YAML 的详细信息,请参考 www.yaml.org 。
 *
 * 用法：
 * <code>
 * $data = load_yaml('myData.yaml');
 * </code>
 *
 * 注意：为了安全起见，不要使用 YAML 存储敏感信息，例如密码。或者将 YAML 文件的
 * 扩展名设置为 .yml.php，并且在每一个 YAML 文件开头加上 # <?php exit(); ?>：
 * <code>
 * # <?php exit(); ?>
 *
 * invoice: 34843
 * date   : 2001-01-23
 * bill-to: &id001
 * ......
 * </code>
 *
 * 这样可以确保即便浏览器直接访问该 .yml.php 文件，也无法看到内容。
 *
 * @param string $filename
 * @param boolean $cacheEnabled 是否缓存分析内容
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

// {{{ HTTP 相关

/**
 * 重定向浏览器到指定的 URL
 *
 * 用法：
 * <code>
 * redirect($url, 5);
 * </code>
 *
 * @param string $url 要重定向的 url
 * @param int $delay 等待多少秒以后跳转
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
 * 构造 url
 *
 * 构造 url 需要提供两个参数：控制器名称和控制器动作名。如果省略这两个参数或者其中一个。
 * 则 url() 函数会使用应用程序设置中的确定的默认控制名称和默认控制器动作名。
 *
 * $mode 有四种：
 *   URL_STANDARD - 标准模式（默认），例如 index.php?url=Login&action=Reject&id=1
 *   URL_PATHINFO - PATHINFO 模式，例如 index.php/Login/Reject/id/1
 *   URL_REWRITE  - URL 重写模式，例如 /Login/Reject/id/1
 *
 * 生成的 url 地址，还要受下列应用程序设置的影响：
 *   - controllerAccessor
 *   - defaultController
 *   - actionAccessor
 *   - defaultAction
 *   - urlMode
 *   - urlLowerChar
 *
 * 用法：
 * <code>
 * $url = url('Login', 'checkUser');
 * // $url 现在为 ?controller=Login&action=checkUser
 *
 * $url = url('Login', 'checkUser', array('username' => 'dualface');
 * // $url 现在为 ?controller=Login&action=checkUser&username=dualface
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
        // PATHINFO 和 REWRITE 模式
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

    // 标准模式
    $url = $_SERVER['SCRIPT_NAME'];
    $url .= '?' . get_app_inf('controllerAccessor'). '=' . rawurlencode($controllerName);
    $url .= '&' . get_app_inf('actionAccessor') . '=' . rawurlencode($actionName);
    if (is_array($params) && !empty($params)) {
        $url .= '&' . encode_url_args($params);
    }
    return $url;
}

/**
 * 将数组转换为可通过 url 传递的字符串连接
 *
 * 用法：
 * <code>
 * $string = encode_url_args(array('username' => 'dualface', 'mode' => 'md5'));
 * // $string 现在为 username=dualface&mode=md5
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

// {{{ 输入输出相关

/**
 * 转换 HTML 特殊字符，等同于 htmlspecialchars()
 *
 * @param string $text
 *
 * @return string
 */
function h($text) {
    return htmlspecialchars($text);
}

/**
 * 转换 HTML 特殊字符以及空格和换行符
 *
 * 空格替换为 &nbsp; ，换行符替换为 <br />。
 *
 * @param string $text
 *
 * @return string
 */
function t($text) {
    return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($text)));
}

/**
 * 输出转换 HTML 特殊字符后的文本，等同于 echo h($text);
 *
 * @param string $text
 */
function echo_h($text) {
    echo htmlspecialchars($text);
}

/**
 * 输出转换 HTML 特殊字符、空格和换行符后的文本，等同于 echo t($text)
 *
 * @param string $text
 */
function echo_t($text) {
    echo t($text);
}

/**
 * 通过 JavaScript 脚本显示提示对话框，并关闭窗口或者重定向浏览器
 *
 * 用法：
 * <code>
 * js_alert('Dialog message', '', $url);
 * // 或者
 * js_alert('Dialog message', 'window.close();');
 * </code>
 *
 * @param string $message 要显示的消息
 * @param string $after_action 显示消息后要执行的动作
 * @param string $url 重定向位置
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
 * 将任意字符串转换为 JavaScript 字符串（不包括首尾的"）
 *
 * @param string $content
 *
 * @return string
 */
function t2js($content) {
    return str_replace("\n", "\\n", addslashes($content));
}

// }}}

// {{{ 文件处理函数
if (!function_exists('file_put_contents')) {
    /**
     * file_put_contents() 一次性完成打开文件，写入内容，关闭文件三项工作
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
 * 创建一个目录树
 *
 * 用法：
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
 * 删除指定目录及其下的所有文件和子目录
 *
 * 用法：
 * <code>
 * // 删除 my_dir 目录及其下的所有文件和子目录
 * rmdirs('/path/to/my_dir');
 * </code>
 *
 * 注意：使用该函数要非常非常小心，避免意外删除重要文件。
 *
 * @param string $dir
 */
function rmdirs($dir) {
    $dir = realpath($dir);
    if ($dir == '' || $dir == '/' ||
        (strlen($dir) == 3 && substr($dir, 1) == ':\\'))
    {
        // 禁止删除根目录
        return false;
    }

    // 遍历目录，删除所有文件和子目录
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

// {{{ 数据库相关

/**
 * 返回数据库访问对象实例
 *
 * $dsn 参数实际上是一个数据库联接配置信息数组，主要包含下列值：
 *   - driver 数据库驱动类型，例如 mysql、pgsql 等；
 *   - host 数据库所在服务器，通常为 localhost 或 127.0.0.1
 *   - port 连接数据库的端口，通常无需指定
 *   - login 连接时使用的用户名
 *   - password 连接时使用的密码
 *   - database 连接后要使用的数据库名
 *   - charset 字符集设置，如果没有设置该选项，则以应用程序设置 databaseCharset 为准
 *   - options 附加的连接选项
 *
 * 只有当提供的 $dsn 参数不同时，get_dbo() 才会返回不同的 SDBO 对象实例。
 *
 * 如果已经调用过 get_dbo()，并成功获得了数据库访问对象实例。那么可以用 get_dbo(false)
 * 获得默认的数据库访问对象实例。
 *
 * 用法：
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
 * 分析 DSN 字符串，返回包含 DSN 连接信息的数组，失败返回 false
 *
 * DSN 字符串采用下面的格式：
 * driver://login:password@host/database/options
 * 对于 DSN 字符串中每一部分的详细解释，请参考 @see get_dbo()。
 *
 * 用法：
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

// {{{ 调试和错误处理相关

/**
 * 抛出一个异常
 *
 * FleaPHP 为了兼容 PHP4，模拟了一种异常机制。但这种模拟机制和真正的异常机制有本质区别。
 * FleaPHP 模拟的异常机制有下列特点：
 *   - 用 __TRY() 而不是 try 设置捕获点；
 *   - 用 __CATCH() 捕获异常，而不是 catch；
 *   - 用 __THROW() 抛出异常；
 *   - __TRY() 和 __CATCH() 并不能够捕获 PHP5 中用 throw 抛出的异常；
 *   - 程序在使用 __THROW() 抛出异常后，必须使用 return false 退出函数或类方法的执行；
 *   - __TRY() 和 __CATCH() 必须成对调用，并且 __CATCH() 只能捕获一个异常；
 *   - 用 __IS_EXCEPTION() 来判断 __CATCH() 的返回值是否是一个异常；
 *   - 如果 __TRY() 调用后没有用 __CATCH() 捕获异常，必须用 __CANCEL_TRY() 取消捕获。
 *
 * 虽然 __THROW() 并不强制要求抛出的异常必须是从 FLEA_Exception 继承的类，但应用程序
 * 应该抛出 FleaPHP 已经定义的异常。或者从 FLEA_Exception 派生应用程序自己的异常。
 * FLEA_Exception 提供了一些方法，可以让应用程序更好的处理异常。
 *
 * 下面的代码片段是模拟异常最常见的使用形式。
 * <code>
 * __TRY();
 * $ret = doSomething(); // 调用可能会发生异常的代码
 * $ex = __CATCH();
 * if (__IS_EXCEPTION($ex)) {
 *     // 处理异常
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
 * <strong>特别要注意的就是使用 __THROW() 抛出异常后，必须 return false</strong>
 *
 * 由于 doSomething() 中的 __THROW() 实际上并不中断程序执行，所以调用 doSomething() 的
 * 代码要负责检查返回值，或者在调用 doSomething() 以后理解捕获异常。
 *
 * 为此，__TRY() 和 __CATCH() 之间的代码要尽可能的少。
 *
 * <strong>对于 __TRY() 和 __CATCH() 的嵌套问题：</strong>
 *
 * FleaPHP 是允许 __TRY() 嵌套的。例如在上面代码中，doSomething() 函数调用了其他可能抛出
 * 异常的代码。则在 doSomething() 中也可以通过 __TRY() 和 __CATCH() 来捕获异常。
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
 *             // 处理 callAnotherFunc() 函数抛出的异常
 *             ...
 *             // 根据处理结果，可以用 __THROW() 重新抛出这个异常，
 *             // 让调用 doSomething() 的代码去处理该异常
 *             __THROW($ex);
 *             return false;
 *         }
 *         return true;
 *     }
 * }
 * </code>
 *
 * 如果调用 __TRY() 之后不需要调用 __CATCH() 捕获异常，则必须用 __CANCEL_TRY()
 * 撤销用 __TRY() 设置的捕获点。
 *
 * @param FLEA_Exception $exception
 */
function __THROW($exception) {
    // 写入日志
    if (function_exists('log_message')) {
        log_message(get_class($exception) . ': ' . $exception->getMessage(), 'exception');
    }

    // 确定是否将异常保存在栈中
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
 * 设置异常拦截点
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
 * 返回抛出的异常，如果没有异常抛出，返回 false
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
 * 清除最后一个 __TRY() 异常捕获设置
 */
function __CANCEL_TRY() {
    if (is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'])) {
        array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
    }
}

/**
 * 判断是否是一个异常
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
 * 设置新的异常处理例程，返回当前使用的异常处理例程
 *
 * 当抛出的异常没有任何 __TRY() 捕获时，将调用异常处理例程。FleaPHP 默认的
 * 异常处理例程会显示异常的详细信息，已经程序运行路径，帮助开发者定位错误。
 *
 * 用法：
 * <code>
 * // 保存现在使用的异常处理例程
 * global $prevExceptionHandler;
 * $prevExceptionHandler = __SET_EXCEPTION_HANDLER('app_exception_handler');
 *
 * function app_exception_handler(& $ex) {
 *     global $prevExceptionHandler;
 *
 *     if (is_a($ex, 'APP_Exception')) {
 *        // 处理该异常
 *        ...
 *     } else {
 *        // 调用原有的异常处理例程
 *        if ($prevExceptionHandler) {
 *            call_user_func_array($prevExceptionHandler, array(& $exception));
 *        }
 *     }
 * }
 * </code>
 *
 * 上面的代码设置了一个新的异常处理例程，同时可以在必要时调用原有的异常处理例程。
 * 虽然不强制要求开发者这样做，但参照上面的代码片段可以形成一个异常处理例程调用链。
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
 * FleaPHP 默认的异常处理例程
 *
 * @param FLEA_Exception $ex
 */
function __FLEA_EXCEPTION_HANDLER($ex) {
    print_ex($ex);
}

/**
 * 打印异常的详细信息
 *
 * @param FLEA_Exception $ex
 * @param boolean $return 为 true 时返回输出信息，而不是直接显示
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
 * 输出变量的内容，通常用于调试
 *
 * @param mixed $vars 要输出的变量
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
 * 显示应用程序执行路径，通常用于调试
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
 * 显示系统错误信息，并中断程序运行
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
 * 查询指定错误信息对应的消息文本
 *
 * 该函数会根据应用程序设置 'defaultLanguage' 载入不同语言的错误信息文件，
 * 然后根据错误代码查询错误消息文本，并返回查询结果。
 *
 * 注意，如果找不到指定语言的错误信息，会载入名为 default 的语言文件。
 *
 * 当 $appError 为 true 时，_E() 会尝试在应用程序设置
 * 'languageFilesDir' 指定的目录中读取语言文件。
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
            // 读取 FleaPHP 自带的错误信息列表
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
