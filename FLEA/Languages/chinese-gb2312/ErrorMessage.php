<?php
/////////////////////////////////////////////////////////////////////////////
// ����ļ��� FleaPHP ��Ŀ��һ����
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// Ҫ�鿴�����İ�Ȩ��Ϣ��������Ϣ����鿴Դ�����и����� COPYRIGHT �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * ���� FleaPHP �����д�����Ϣ�Ĵ��뼰��Ӧ�Ĵ�����Ϣ
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Core
 * @version $Id: ErrorMessage.php 640 2006-12-19 11:51:09Z dualface $
 */

return array(
    // FLEA_Exception_ExpectedFile
    0x0102001 => '��Ҫ���ļ� "%s" û���ҵ�.',
    // FLEA_Exception_ExpectedClass
    0x0102002 => '�ļ� "%s" ��û�ж�����Ҫ���� "%s".',
    0x0102003 => 'û�ж�����Ҫ���� "%s".',
    // FLEA_Exception_ExistsKeyName
    0x0102004 => '���� "%s" �Ѿ�����.',
    // FLEA_Exception_FileOperation
    0x0102005 => '�ļ�ϵͳ���� "%s" ʧ��.',
    // FLEA_Exception_InvalidArguments
    0x0102006 => '��Ч�Ĳ��� "%s".',
    // FLEA_Exception_MissingArguments
    0x0102007 => 'û���ṩ��Ҫ�� "%s" ����.',
    // FLEA_Exception_MustOverwrite
    0x0102008 => '�����ڼ̳����и����෽�� "%s".',

    // FLEA_Exception_NotExistsKeyName
    0x0102009 => '��Ҫ�ļ��� "%s" ������.',
    // FLEA_Exception_NotImplemented
    0x010200a => '�෽�� "%s::%s" û��ʵ��.',
    0x010200b => '���� "%s" û��ʵ��.',
    // FLEA_Exception_TypeMismatch
    0x010200c => '���� "%s" Ԥ�ڵ������� "%s", ����ʵ������Ϊ "%s".',

    // FLEA_Exception_MissingAction
    0x0103001 => 'ȱ�ٿ��������� "%s::%s()".',
    // FLEA_Exception_MissingController
    0x0103002 => 'ȱ�ٿ����� "%s".',

    // FLEA_Exception_ValidationFailed
    0x0407001 => '����������֤ʧ��: "%s".',

    // FLEA_Com_RBAC_Exception_InvalidACT
    0x0701001 => '��Ч�ķ��ʿ��Ʊ���Access-Control-Table (ACT)������.',
    // FLEA_Com_RBAC_Exception_InvalidACTFile
    0x0701002 => '������ "%s" ʹ������Ч�ķ��ʿ��Ʊ���Access-Control-Table (ACT)���ļ�.',
    0x0701003 => '��Ч�ķ��ʿ��Ʊ���Access-Control-Table (ACT)���ļ�.',
    // FLEA_Dispatcher_Exception_CheckFailed
    0x0701004 => '�ܾ����ʿ���������: "%s::%s".',

    // FLEA_Db_Exception_InvalidDSN
    0x06ff001 => '��Ч������Դ���ơ�Data-Source-Name (DSN)��.',
    // FLEA_Db_Exception_MissingDSN
    0x06ff002 => 'ȱ��Ӧ�ó�������: dbDSN.',
    // FLEA_Db_Exception_MissingPrimaryKey
    0x06ff003 => 'ȱ������ "%s" ��ֵ.',
    // FLEA_Db_Exception_PrimaryKeyExists
    0x06ff004 => '����ֵ "%s" = "%s" �Ѿ�����.',
    // FLEA_Db_Exception_SqlQuery
    0x06ff005 => "SQL ������Ϣ: \"%s\"\nSQL ���: \"%s\"\nSQL �������: \"%s\".",
    0x06ff006 => "SQL ���: \"%s\"\nSQL �������: \"%s\".",

    // FLEA_Db_Exception_InvalidLinkType
    0x0202001 => '��Ч�����ݱ��������� "%s".',
    // FLEA_Db_Exception_MissingLinkOption
    0x0202002 => '�������ݱ�����ʱȱ�ٱ���� "%s" ѡ��.',

    // FLEA_View_Exception_NotConfigurationSmarty
    0x0902001 => 'FLEA_View_Smarty ��ҪӦ�ó������� "viewConfig[\'smartyDir\']"�������峣�� SMARTY_DIR.',
    // FLEA_View_Exception_InitSmartyFailed
    0x0902002 => 'Smarty ģ�������ļ� "%s" û���ҵ�.',

    // FLEA_View_Exception_NotConfigurationSmartTemplate
    0x0903001 => 'FLEA_View_SmartTemplate ��ҪӦ�ó������� "viewConfig[\'smartDir\']".',
    // FLEA_View_Exception_InitSmartTemplateFailed
    0x0903002 => 'SmartTemplate ģ�������ļ� "%s" û���ҵ�.',
);