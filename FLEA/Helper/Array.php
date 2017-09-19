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
 * ������һϵ�����ڼ���������ĺ���
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: Array.php 640 2006-12-19 11:51:09Z dualface $
 */

/**
 * ��������ɾ���հ׵�Ԫ�أ�����ֻ�пհ��ַ���Ԫ�أ�
 *
 * @param array $arr
 * @param boolean $trim
 */
function array_remove_empty(& $arr, $trim = true) {
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            array_remove_empty($arr[$key]);
        } else {
            $value = trim($value);
            if ($value == '') {
                unset($arr[$key]);
            } elseif ($trim) {
                $arr[$key] = $value;
            }
        }
    }
}

/**
 * ��һ����ά�����з���ָ����������ֵ
 *
 * @param array $arr
 * @param string $col
 *
 * @return array
 */
function array_col_values(& $arr, $col) {
    $ret = array();
    foreach ($arr as $row) {
        if (isset($row[$col])) { $ret[] = $row[$col]; }
    }
    return $ret;
}

/**
 * ��һ����ά����ת��Ϊ hashmap
 *
 * ���ʡ�� $valueField ��������ת�����ÿһ��Ϊ���������������ݵ����顣
 *
 * @param array $arr
 * @param string $keyField
 * @param string $valueField
 *
 * @return array
 */
function array_to_hashmap(& $arr, $keyField, $valueField = null) {
    $ret = array();
    if ($valueField) {
        foreach ($arr as $row) {
            $ret[$row[$keyField]] = $row[$valueField];
        }
    } else {
        foreach ($arr as $row) {
            $ret[$row[$keyField]] = $row;
        }
    }
    return $ret;
}

/**
 * ��һ����ά���鰴��ָ���ֶε�ֵ����
 *
 * @param array $arr
 * @param string $keyField
 *
 * @return array
 */
function array_group_by(& $arr, $keyField) {
    $ret = array();
    foreach ($arr as $row) {
        $key = $row[$keyField];
        $ret[$key][] = $row;
    }
    return $ret;
}

/**
 * ��һ��ƽ��Ķ�ά���鰴��ָ�����ֶ�ת��Ϊ��״�ṹ
 *
 * �� $returnReferences ����Ϊ true ʱ�����ؽ���� tree �ֶ�Ϊ����refs �ֶ���Ϊ�ڵ����á�
 * ���÷��صĽڵ����ã����Ժܷ���Ļ�ȡ����������ڵ�Ϊ����������
 *
 * @param array $arr ԭʼ����
 * @param string $fid �ڵ�ID�ֶ���
 * @param string $fparent �ڵ㸸ID�ֶ���
 * @param string $fchildrens �����ӽڵ���ֶ���
 * @param boolean $returnReferences �Ƿ��ڷ��ؽ���а����ڵ�����
 *
 * return array
 */
function array_to_tree($arr, $fid, $fparent = 'parent_id',
    $fchildrens = 'childrens', $returnReferences = false)
{
    $pkvRefs = array();
    foreach ($arr as $offset => $row) {
        $pkvRefs[$row[$fid]] =& $arr[$offset];
    }

    $tree = array();
    foreach ($arr as $offset => $row) {
        $parentId = $row[$fparent];
        if ($parentId) {
            if (!isset($pkvRefs[$parentId])) { continue; }
            $parent =& $pkvRefs[$parentId];
            $parent[$fchildrens][] =& $arr[$offset];
        } else {
            $tree[] =& $arr[$offset];
        }
    }
    if ($returnReferences) {
        return array('tree' => $tree, 'refs' => $pkvRefs);
    } else {
        return $tree;
    }
}

/**
 * ����ת��Ϊƽ�������
 *
 * @param array $node
 * @param string $fchildrens
 *
 * @return array
 */
function tree_to_array(& $node, $fchildrens = 'childrens') {
    $ret = array();
    if (isset($node[$fchildrens]) && is_array($node[$fchildrens])) {
        foreach ($node[$fchildrens] as $child) {
            $ret = array_merge($ret, tree_to_array($child, $fchildrens));
        }
        unset($node[$fchildrens]);
        $ret[] = $node;
    } else {
        $ret[] = $node;
    }
    return $ret;
}

/**
 * ����ָ���ļ�ֵ����������
 *
 * @param array $array Ҫ���������
 * @param string $keyname ��ֵ����
 * @param int $sortDirection ������
 *
 * @return array
 */
function array_column_sort($array, $keyname, $sortDirection = SORT_ASC) {
    return array_sortby_multifields($array, array($keyname => $sortDirection));
}

/**
 * ��һ����ά���鰴��ָ���н����������� SQL ����е� ORDER BY
 *
 * @param array $rowset
 * @param array $args
 */
function array_sortby_multifields($rowset, $args) {
    $sortArray = array();
    $sortRule = '';
    foreach ($args as $sortField => $sortDir) {
        foreach ($rowset as $offset => $row) {
            $sortArray[$sortField][$offset] = $row[$sortField];
        }
        $sortRule .= '$sortArray[\'' . $sortField . '\'], ' . $sortDir . ', ';
    }
    if (empty($sortArray) || empty($sortRule)) { return $rowset; }
    eval('array_multisort(' . $sortRule . '$rowset);');
    return $rowset;
}
