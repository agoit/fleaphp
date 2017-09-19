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
 * �������� PHP4 �� FLEA_Exception ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Exception
 * @version $Id: ExceptionPHP4.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * FLEA_Exception ���װ��һ���쳣
 *
 * �� PHP5 �У�FLEA_Exception �̳��� PHP ���õ� Exception �ࡣ
 * �� PHP4 �У���ģ�����쳣���ơ�
 *
 * @package Exception
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Exception
{
    /**
     * �쳣��Ϣ
     *
     * @var string
     */
    var $message = 'Unknown exception';

    /**
     * �������
     */
    var $code = 0;

    /**
     * �׳��쳣���ļ�
     *
     * @var string
     */
    var $file;

    /**
     * �׳��쳣������к�
     *
     * @var int
     */
    var $line;

    /**
     * ���ö�ջ
     *
     * @var array
     */
    var $trac;

    /**
     * ���캯��
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

        // ȡ���׳��쳣���ļ��ʹ����к�
        $last = array_shift($this->trac);
        $this->file = $last['file'];
        $this->line = $last['line'];
    }

    /**
     * ����쳣������Ϣ
     *
     * @return string
     */
    function getMessage() {
        return $this->message;
    }

    /**
     * ����쳣�������
     *
     * @return int
     */
    function getCode() {
        return $this->code;
    }

    /**
     * ����׳��쳣���ļ���
     *
     * @return string
     */
    function getFile() {
        return $this->file;
    }

    /**
     * ����׳��쳣�Ĵ����к�
     *
     * @return int
     */
    function getLine() {
        return $this->line;
    }

    /**
     * ���ص��ö�ջ
     *
     * @return array
     */
    function getTrace() {
        return $this->trac;
    }

    /**
     * �����ַ�����ʾ�ĵ��ö�ջ
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
     * �����쳣���ַ�����ʽ
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
