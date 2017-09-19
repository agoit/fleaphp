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
 * ���� FLEA_Helper_Validation ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: Validation.php 683 2007-01-05 16:27:22Z dualface $
 */

/**
 * FLEA_Helper_Validation �������һϵ����֤�����ָ�������ݽ�����֤
 *
 * ��֤�����ɶ��������ɣ�ÿ������������֤һ���ֶΡ�
 *
 * ÿ��������԰������л������ԣ�
 * name:            �ֶ���
 * scale:           С��λ��
 * type:            �ֶ�����
 * simpleType:      ���ֶ�����
 * maxLength:       ��󳤶�
 * notNull:         �Ƿ������� NULL ֵ
 * binary:          �Ƿ��Ƕ���������
 * unsigned:        �Ƿ����޷�����ֵ
 * hasDefault:      �Ƿ���Ĭ��ֵ
 * defaultValue:    Ĭ��ֵ
 *
 * ��� notNull Ϊ true���� hasDefault Ϊ false�����ʾ���ֶα��������ݡ�
 *
 * simpleType ���Կ���������ֵ��
 *	C        - ����С�ڵ��� 250 ���ַ���
 *	X        - ���ȴ��� 250 ���ַ���
 *	B        - ����������
 * 	N        - ��ֵ���߸�����
 *	D        - ����
 *	T        - TimeStamp
 * 	L        - �߼�����ֵ
 *	I        - ����
 *  R        - �Զ������������
 *
 * �������Ժ����� SDBO::metaColumns() ����ȡ�õ��ֶ���Ϣ��ȫһ�¡�
 * ��˿���ֱ�ӽ� metaColumns() �ķ��ؽ����Ϊ��֤����
 *
 * Ϊ�˻�ø�ǿ����֤������������ʹ��������չ���ԣ�
 *
 * complexType:     �����ֶ�����
 * min:             ��Сֵ����������ֵ���ֶΣ�
 * max:             ���ֵ����������ֵ���ֶΣ�
 * minLength:       ��С���ȣ��������ַ��ͺ��ı����ֶΣ�
 * maxLength:       ��󳤶ȣ��������ַ��к��ı����ֶΣ�
 *
 * ���� complexType ���ԣ�����������ֵ��
 * NUMBER     - ��ֵ����������������
 * INT        - ����
 * ASCII      - ASCII �ַ��������б���С�ڵ��� 127 ���ַ���
 * EMAIL      - Email ��ַ
 * DATE       - ���ڣ����� GNU Date Input Formats������ yyyy/mm/dd��yyyy-mm-dd��
 * TIME       - ʱ�䣨���� GNU Date Input Formats������ hh:mm:ss��
 * IPv4       - IPv4 ��ַ����ʽΪ a.b.c.h��
 * OCTAL      - �˽�����ֵ
 * BINARY     - ��������ֵ
 * HEX        - ʮ��������ֵ
 * DOMAIN     - Internet ����
 * ANY        - ��������
 * STRING     - �ַ�������ͬ���������ͣ�
 * ALPHANUM   - ���ֺ����֣�26����ĸ��0��9��
 * ALPHA      - ���֣�26����ĸ��
 * ALPHANUMX  - 26����ĸ��10�������Լ� _ ����
 *
 * @package Helper
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_Validation
{
    /**
     * ��������ֶΣ�������֤���
     *
     * @param array $data
     * @param array $rules
     * @param boolean $skipEmpty
     *
     * @return array
     */
    function checkAll(& $data, & $rules, $skipEmpty = false) {
        $result = array();
        foreach ($rules as $rule) {
            $name = $rule['name'];
            if ((!isset($data[$name]) || empty($data[$name])) && $skipEmpty) { continue; }
            do {
                // ��� notNull Ϊ true���� hasDefault Ϊ false�����ʾ���ֶα���������
                if ($rule['notNull']) {
                    if (isset($rule['hasDefault']) && $rule['hasDefault']) { break; }
                    if ($rule['simpleType'] == 'R') { break; }
                    if (!isset($data[$name]) || $data[$name] === '') {
                        $result[$name] = false;
                        break;
                    }
                } else {
                    if (!isset($data[$name]) || $data[$name] === '') {
                        break;
                    }
                }

                if (!$this->check($rule, $data[$name])) { $result[$name] = false; }
            } while (false);
        }
        return $result;
    }

    /**
     * ��ָ��������ֵ֤����������֤���
     *
     * @param array $rule
     * @param mixed $value
     *
     * @return boolean
     */
    function check(& $rule, $value) {
        // ����ʹ�� simpleType ��ֵ֤����� simpleType ���Դ��ڣ�
        $checkLength = false;
        $checkMinMax = false;
        if (isset($rule['simpleType'])) {
            switch ($rule['simpleType']) {
            case 'C': // ����С�ڵ��� 250 ���ַ���
                if (strlen($value) > 250) { return false; }
                $checkLength = true;
                break;
            case 'N': // ��ֵ���߸�����
                if (!is_numeric($value)) { return false; }
                $checkMinMax = true;
                break;
            case 'D': // ����
                $test = strtotime($value);
                if ($test === false || $test === -1) { return false; }
                break;
            case 'I': // ����
                if (!is_numeric($value)) { return false; }
                if (intval($value) != $value) { return false; }
                $checkMinMax = true;
                break;
            case 'X': // ���ȴ��� 250 ���ַ���
            case 'B': // ����������
                $checkLength = true;
                break;
            case 'T': // TimeStamp
            case 'L': // �߼�����ֵ
                break;
            case 'R': // �Զ������������
                $checkMinMax = true;
                break;
            default:
            }
        } else {
            $checkLength = true;
            $checkMinMax = true;
        }

        // ����ʹ�� complexType ��ֵ֤����� complexType ���Դ��ڣ�
        if (isset($rule['complexType'])) {
            $func = 'is' . $rule['complexType'];
            if (!method_exists($this, $func)) {
                load_class('FLEA_Exception_InvalidArguments');
                __THROW(new FLEA_Exception_InvalidArguments('$rule[\'complexType\']', $rule['complexType']));
                return null;
            }
            if (!$this->{$func}($value)) { return false; }
        }

        // min/max/minLength/maxLength ��֤
        if ($checkMinMax) {
            if (isset($rule['min']) && $value < $rule['min']) { return false; }
            if (isset($rule['max']) && $value > $rule['max']) { return false; }
        }
        if ($checkLength) {
            if (isset($rule['minLength']) && $rule['minLength'] > 0 &&
                strlen($value) < $rule['minLength']) {
                return false;
            }
            if (isset($rule['maxLength']) && $rule['maxLength'] > 0 &&
                strlen($value) > $rule['maxLength']) {
                return false;
            }
        }

        return true;
    }

    /**
     * ����
     */
    function isNUMBER($value) {
        return is_numeric($value);
    }

    /**
     * ����
     */
    function isINT($value) {
        return strlen(intval($value)) == strlen($value) && is_numeric($value);
    }

    /**
     * ASCII �ַ��������б���С�ڵ��� 127 ���ַ���
     */
    function isASCII($value) {
        $count = preg_match_all('/[\x20-\x7f]/', $value, $ar);
        return $count == strlen($value);
    }

    /**
     * Email ��ַ
     */
    function isEMAIL($value) {
        return preg_match('/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*@([A-Za-z0-9]+[-A-Za-z0-9]*[A-Za-z0-9]+\.)+[A-Za-z0-9]+$/', $value) != 0;
    }

    /**
     * ���ڣ����� GNU Date Input Formats������ yyyy/mm/dd��yyyy-mm-dd��
     */
    function isDATE($value) {
        $test = strtotime($value);
        return $test !== -1 && $test !== false;
    }

    /**
     * ʱ�䣨���� GNU Date Input Formats������ hh:mm:ss��
     */
    function isTIME($value) {
        $test = strtotime($value);
        return $test !== -1 && $test !== false;
    }

    /**
     * IPv4 ��ַ����ʽΪ a.b.c.h��
     */
    function isIPv4($value) {
        $test = ip2long($value);
        return $test !== -1 && $test !== false;
    }

    /**
     * �˽�����ֵ
     */
    function isOCTAL($value) {
        return preg_match('/0[0-7]+/', $value) != 0;
    }

    /**
     * ��������ֵ
     */
    function isBINARY($value) {
        return preg_match('/[01]+/', $value) != 0;
    }

    /**
     * ʮ��������ֵ
     */
    function isHEX($value) {
        return preg_match('/[0-9a-f]+/i', $value) != 0;
    }

    /**
     * Internet ����
     */
    function isDOMAIN($value) {
        return preg_match('/[a-z0-9\.]+/i') != 0;
    }

    /**
     * ��������
     */
    function isANY($value) {
        return true;
    }

    /**
     * �ַ�������ͬ���������ͣ�
     */
    function isSTRING($value) {
        return true;
    }

    /**
     * ���ֺ����֣�26����ĸ��0��9��
     */
    function isALPHANUM($value) {
        return ctype_alnum($value);
    }

    /**
     * ���֣�26����ĸ��
     */
    function isALPHA($value) {
        return ctype_alpha($value);
    }

    /**
     * 26����ĸ��10������
     */
    function isALPHANUMX($value) {
        return preg_match('/[A-Za-z0-9_]+/', $value) != 0;
    }
}
