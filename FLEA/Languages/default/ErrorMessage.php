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
 * 定义 FleaPHP 中所有错误信息的代码及对应的错误信息
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Core
 * @version $Id: ErrorMessage.php 640 2006-12-19 11:51:09Z dualface $
 */

return array(
    // FLEA_Exception_ExpectedFile
    0x0102001 => 'Expected file "%s" not found.',
    // FLEA_Exception_ExpectedClass
    0x0102002 => 'Expected class "%s" not defined in file "%s"%.',
    0x0102003 => 'Expected class "%s" not defined.',
    // FLEA_Exception_ExistsKeyName
    0x0102004 => 'Key name "%s" already exists.',
    // FLEA_Exception_FileOperation
    0x0102005 => 'FileSystem operation "%s" failed.',
    // FLEA_Exception_InvalidArguments
    0x0102006 => 'Argument "%s" invalid.',
    // FLEA_Exception_MissingArguments
    0x0102007 => 'Expected arguments "%s" not found.',
    // FLEA_Exception_MustOverwrite
    0x0102008 => 'Class method "%s" must overwrite in derived class.',
    // FLEA_Exception_NotExistsKeyName
    0x0102009 => 'Key name "%s" NOT exists.',
    // FLEA_Exception_NotImplemented
    0x010200a => 'Class method "%s::%s" not implemented.',
    0x010200b => 'Function "%s" not implemented.',
    // FLEA_Exception_TypeMismatch
    0x010200c => 'Argument "%s" exceped type "%s", but actual type is "%s".',

    // FLEA_Exception_MissingAction
    0x0103001 => 'Missing controller action method "%s::%s()".',
    // FLEA_Exception_MissingController
    0x0103002 => 'Missing controller "%s".',

    // FLEA_Exception_ValidationFailed
    0x0407001 => 'Data validation failed: "%s".',

    // FLEA_Com_RBAC_Exception_InvalidACT
    0x0701001 => 'Invalid Access-Control-Table (ACT) data.',
    // FLEA_Com_RBAC_Exception_InvalidACTFile
    0x0701002 => 'Invalid ACT file "%s" for controller "%s".',
    0x0701003 => 'Invalid ACT file "%s".',
    // FLEA_Dispatcher_Exception_CheckFailed
    0x0701004 => 'ACCESS DENY CONTROLLER ACTION: "%s::%s".',

    // FLEA_Db_Exception_InvalidDSN
    0x06ff001 => 'Invalid Data-Source-Name (DSN) data.',
    // FLEA_Db_Exception_MissingDSN
    0x06ff002 => 'Missing application config item: dbDSN.',
    // FLEA_Db_Exception_MissingPrimaryKey
    0x06ff003 => 'Missing primary key "%s".',
    // FLEA_Db_Exception_PrimaryKeyExists
    0x06ff004 => 'Primary key "%s" = "%s" exists.',
    // FLEA_Db_Exception_SqlQuery
    0x06ff005 => "\"%s\"\nSQL Script: \"%s\"\nSQL Error Code: \"%s\".",
    0x06ff006 => "SQL Script: \"%s\"\nSQL Error Code: \"%s\".",

    // FLEA_Db_Exception_InvalidLinkType
    0x0202001 => 'Invalid TableLink type "%s".',
    // FLEA_Db_Exception_MissingLinkOption
    0x0202002 => 'Missing expected TableLink option "%s".',

    // FLEA_View_Exception_NotConfigurationSmarty
    0x0902001 => 'FLEA_View_Smarty requirement viewConfig[\'smartyDir\'] and SMARTY_DIR constant.',
    // FLEA_View_Exception_InitSmartyFailed
    0x0902002 => 'Smarty engine file: "%s" not found.',

    // FLEA_View_Exception_NotConfigurationSmartTemplate
    0x0903001 => 'FLEA_View_SmartTemplate requirement viewConfig[\'smartDir\'].',
    // FLEA_View_Exception_InitSmartTemplateFailed
    0x0903002 => 'SmartTemplate engine file: "%s" not found.',
);
