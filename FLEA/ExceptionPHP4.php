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
 * 定义用于 PHP4 的 FLEA_Exception 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Exception
 * @version $Id: ExceptionPHP4.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception 类封装了一个异常
 *
 * 在 PHP5 中，FLEA_Exception 继承自 PHP 内置的 Exception 类。
 * 在 PHP4 中，则模拟了异常机制。
 *
 * @package Exception
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception
{
    /**
     * 异常消息
     *
     * @var string
     */
    var $message = 'Unknown exception';

    /**
     * 错误代码
     */
    var $code = 0;

    /**
     * 抛出异常的文件
     *
     * @var string
     */
    var $file;

    /**
     * 抛出异常代码的行号
     *
     * @var int
     */
    var $line;

    /**
     * 调用堆栈
     *
     * @var array
     */
    var $trac;

    /**
     * 构造函数
     *
     * @param string $message
     * @param int $code
     *
     * @return FLEA_Exception
     */
    function FLEA_Exception($message = null, $code = 0) {
        $this->message = $message;
        $this->code = $code;
        $this->trac = debug_backtrace();

        // 取得抛出异常的文件和代码行号
        $last = array_shift($this->trac);
        $this->file = $last['file'];
        $this->line = $last['line'];
    }

    /**
     * 获得异常错误信息
     *
     * @return string
     */
    function getMessage() {
        return $this->message;
    }

    /**
     * 获得异常错误代码
     *
     * @return int
     */
    function getCode() {
        return $this->code;
    }

    /**
     * 获得抛出异常的文件名
     *
     * @return string
     */
    function getFile() {
        return $this->file;
    }

    /**
     * 获得抛出异常的代码行号
     *
     * @return int
     */
    function getLine() {
        return $this->line;
    }

    /**
     * 返回调用堆栈
     *
     * @return array
     */
    function getTrace() {
        return $this->trac;
    }

    /**
     * 返回字符串表示的调用堆栈
     */
    function getTraceAsString() {
        $out = '';
        $ix = 0;
        foreach ($this->trac as $point) {
            $out .= "#{$ix} {$point['file']}({$point['line']}): {$point['function']}(";
            if (is_array($point['args']) && count($point['args']) > 0) {
                foreach ($point['args'] as $arg) {
                    switch (gettype($arg)) {
                    case 'array':
                    case 'resource':
                        $out .= gettype($arg);
                        break;
                    case 'object':
                        $out .= get_class($arg);
                        break;
                    case 'string':
                        if (strlen($arg) > 30) {
                            $arg = substr($arg, 0, 27) . ' ...';
                        }
                        $out .= "'{$arg}'";
                        break;
                    default:
                        $out .= $arg;
                    }
                    $out .= ', ';
                }
                $out = substr($out, 0, -2);
            }
            $out .= ")\n";
            $ix++;
        }
        $out .= "#{$ix} {main}\n";

        return $out;
    }

    /**
     * 返回异常的字符串形式
     *
     * @return string
     */
    function __toString() {
        $out = "exception '" . get_class($this) . "'";
        if ($this->message != '') {
            $out .= " with message '{$this->message}'";
        }
        $out .= " in {$this->file}:{$this->line}\n\n";
        $out .= $this->getTraceAsString();
        return $out;
    }
}
