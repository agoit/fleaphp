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
 * ���� FLEA_Com_Log ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Log
 * @version $Id: Log.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * ׷����־��¼
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
         * �����ֵ��﷨����Ϊ PHP4 �������ڲ��ľ�̬����ʱ������
         */
        $log = array('obj' => & $obj);
    }
    $log['obj']->appendLog($msg, $level);
}

/**
 * FLEA_Com_Log ���ṩ��������־����
 *
 * @package Log
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Com_Log {
    /**
     * ���������ڼ����־���ڽ̱�����ʱ����־����д�뵽�ļ�
     *
     * @var string
     */
    var $_log = '';

    /**
     * ���ڸ�ʽ
     *
     * @var string
     */
    var $dateFormat = 'Y-m-d H:i:s';

    /**
     * ������־�ļ���Ŀ¼
     *
     * @var string
     */
    var $_logFileDir;

    /**
     * ������־���ļ���
     *
     * @var string
     */
    var $_logFilename;

    /**
     * �Ƿ�������־����
     *
     * @var boolean
     */
	var $_enabled = true;

	/**
	 * Ҫд����־�ļ��Ĵ��󼶱�
	 *
	 * @var array
	 */
	var $_errorLevel;

	/**
	 * ���캯��
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

            // ע��ű�����ʱҪ���еķ��������������־����д���ļ�
    	    register_shutdown_function(array(& $this, '__writeLog'));

    	    // ����ļ��Ƿ��Ѿ�����ָ����С
            $filesize = @filesize($this->_logFilename);
            $maxsize = (int)get_app_inf('logFileMaxSize');
            if ($maxsize >= 512) {
                $maxsize = $maxsize * 1024;
                if ($filesize >= $maxsize) {
                    // ʹ���µ���־�ļ���
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
	 * ׷����־��Ϣ
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
     * ����־��Ϣд�뻺��
     */
    function __writeLog() {
        global $___fleaphp_loaded_time;

        // ����Ӧ�ó���ִ��ʱ�䣨����������ļ���
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
