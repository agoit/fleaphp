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
 * 定义 FLEA_Com_Log 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Log
 * @version $Id: Log.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * 追加日志记录
 *
 * @param string $msg
 * @param string $level
 */
function log_message($msg, $level) {
    static $log = null;
    if (is_null($log)) {
        $obj =& new FLEA_Com_Log();
        reg($obj, 'FLEA_Com_Log');
        /**
         * 如此奇怪的语法是因为 PHP4 处理函数内部的静态变量时有问题
         */
        $log = array('obj' => & $obj);
    }
    $log['obj']->appendLog($msg, $level);
}

/**
 * FLEA_Com_Log 类提供基本的日志服务
 *
 * @package Log
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_Log {
    /**
     * 保存运行期间的日志，在教本结束时将日志内容写入到文件
     *
     * @var string
     */
    var $_log = '';

    /**
     * 日期格式
     *
     * @var string
     */
    var $dateFormat = 'Y-m-d H:i:s';

    /**
     * 保存日志文件的目录
     *
     * @var string
     */
    var $_logFileDir;

    /**
     * 保存日志的文件名
     *
     * @var string
     */
    var $_logFilename;

    /**
     * 是否允许日志保存
     *
     * @var boolean
     */
	var $_enabled = true;

	/**
	 * 要写入日志文件的错误级别
	 *
	 * @var array
	 */
	var $_errorLevel;

	/**
	 * 构造函数
	 *
	 * @return FLEA_Com_Log
	 */
	function FLEA_Com_Log() {
	    $dir = get_app_inf('logFileDir');
	    if ($dir == null || $dir == '' || !is_dir($dir) || !is_writable($dir)) {
	        $this->_enabled = false;
	    } else {
	        $this->_logFileDir = $dir;
    	    $this->_logFilename = $this->_logFileDir . DS . get_app_inf('logFilename');
    	    $errorLevel = explode(',', strtolower(get_app_inf('logErrorLevel')));
    	    $errorLevel = array_map('trim', $errorLevel);
    	    $errorLevel = array_filter($errorLevel, 'trim');
    	    $this->_errorLevel = array();
    	    foreach ($errorLevel as $e) {
    	       $this->_errorLevel[$e] = true;
    	    }

    	    global $___fleaphp_loaded_time;
            list($usec, $sec) = explode(" ", $___fleaphp_loaded_time);
            $this->_log = sprintf("[%s %s] FleaPHP Loaded =======\n",
                date($this->dateFormat, $sec), $usec);

            $this->_log .= sprintf("[%s] REQUEST_URI: %s\n", date($this->dateFormat),
                $_SERVER['REQUEST_URI']);

            // 注册脚本结束时要运行的方法，将缓存的日志内容写入文件
    	    register_shutdown_function(array(& $this, '__writeLog'));

    	    // 检查文件是否已经超过指定大小
            $filesize = @filesize($this->_logFilename);
            $maxsize = (int)get_app_inf('logFileMaxSize');
            if ($maxsize >= 512) {
                $maxsize = $maxsize * 1024;
                if ($filesize >= $maxsize) {
                    // 使用新的日志文件名
                    $pathinfo = pathinfo($this->_logFilename);
                    $newFilename = $pathinfo['dirname'] . DS .
                        basename($pathinfo['basename'], '.' . $pathinfo['extension']) .
                        date('-Ymd-His') . '.' . $pathinfo['extension'];
                    rename($this->_logFilename, $newFilename);
                }
            }
	    }
	}

	/**
	 * 追加日志信息
	 *
	 * @param string $msg
	 * @param string $level
	 */
	function appendLog($msg, $level) {
	    if (!$this->_enabled) { return; }
	    $level = strtolower($level);
	    if (!isset($this->_errorLevel[$level])) { return; }

        $msg = sprintf("[%s] [%s] %s\n", date($this->dateFormat), $level, $msg);
        $this->_log .= $msg;
    }

    /**
     * 将日志信息写入缓存
     */
    function __writeLog() {
        global $___fleaphp_loaded_time;

        // 计算应用程序执行时间（不包含入口文件）
        list($usec, $sec) = explode(" ", $___fleaphp_loaded_time);
        $beginTime = (float)$sec + (float)$usec;
        $endTime = microtime();
        list($usec, $sec) = explode(" ", $endTime);
        $endTime = (float)$sec + (float)$usec;
        $elapsedTime = $endTime - $beginTime;
        $this->_log .= sprintf("[%s %s] FleaPHP End (elapsed: %f seconds) =======\n\n",
            date($this->dateFormat, $sec), $usec, $elapsedTime);

        $fp = fopen($this->_logFilename, 'a');
        if (!$fp) { return; }
        flock($fp, LOCK_EX);
        fwrite($fp, $this->_log);
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
