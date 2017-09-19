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
 * 定义 SHOP 示例程序后台界面的信息字符串
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Example
 * @subpackage SHOP
 * @version $Id: ui.php 682 2007-01-05 16:25:15Z dualface $
 */

return array(
    /**
     * ui_l - 登錄界面
     */
    'ui_l_title' => '登錄后臺管理',
    'ui_l_welcome' => "
歡迎使用“%s”后臺管理系統！

演示用戶：admin
演示密碼：123456

注意：請確保 upload 目錄可以允許 PHP 程序創建新文件。",
    'ui_l_username' => '管理員帳戶:',
    'ui_l_password' => '管理員密碼:',
    'ui_l_imgcode' => '驗證碼:',
    'ui_l_login' => ' 登 錄 ',
    'ui_l_form_validation' => '必須輸入用戶名和密碼才能登錄。',
    'ui_l_logout' => '您已經成功退出了登錄。',
    'ui_l_invalid_imgcode' => '您輸入的驗證碼無效，或者驗證碼已經過期。請重新登錄。',
    'ui_l_invalid_username' => '您輸入的用戶名不存在，請檢查后重新登錄。',
    'ui_l_invalid_password' => '您輸入的密碼不正確，請檢查后重新登錄。',
    'ui_l_languages' => '界面語言:',


    /**
     * ui_w - 歡迎頁面
     */
    'ui_w_title' => '后臺管理',
    'ui_w_page_welcome' => '后臺歡迎頁面',
    'ui_w_user' => '用戶:',
    'ui_w_logout' => '注銷登錄',
    'ui_w_menu_create_product' => '添加商品',
    'ui_w_menu_list_product' => '管理商品',
    'ui_w_menu_list_classes' => '商品分類維護',
    'ui_w_catalog_products' => '商品及分類管理',
    'ui_w_welcome' => "歡迎使用 %s 后臺管理系統！",
    'ui_w_instruction' => "\n\n請從左邊菜單選擇要使用的功能。\n\n\n關閉窗口前請務必點擊最上方的“注銷登錄”連接。",
    'ui_w_link_phpinfo' => '查看系統信息',
    'ui_w_languages' => '選擇界面語言:',

    /**
     * ui_c - 分類管理界面
     */
    'ui_c_title' => '商品分類維護',
    'ui_c_create' => '添加分類',
    'ui_c_edit' => '修改分類',
    'ui_c_description' => '在這里，您可以查看商品分類列表。也可以添加新分類或者修改、刪除現有的分類。',
    'ui_c_edit_description' => '添加分類或修改分類，必須輸入分類名稱并選擇父分類。',
    'ui_c_class_name' => '分類名稱',
    'ui_c_child_count' => '所有子分類數',
    'ui_c_current_location' => '當前位置：',
    'ui_c_calc_child_count' => '，該分類共有子分類 %u 個',
    'ui_c_no_subclasses' => '當前分類下沒有任何子分類。',
    'ui_c_root_dir' => '根目錄',
    'ui_c_parent_class' => '父分類',
    'ui_c_remove_confirm' => '您確定要刪除該分類及其所有子分類？',
    'ui_c_operation_list_child' => '查看子分類',
    'ui_c_form_validation' => '必須輸入分類名稱',
    'ui_c_invalid_parent_id' => '無效的參數：parent_id = %s',
    'ui_c_invalid_class_id' => '無效的參數：class_id = %s',
    'ui_c_new_top_class' => '（創建新的頂級分類）',

    /**
     * ui_p - 產品管理界面
     */
    'ui_p_title' => '產品管理',
    'ui_p_create' => '添加產品',
    'ui_p_edit' => '修改產品',
    'ui_p_description' => '在這里，您可以查看產品列表。也可以添加新產品或者修改、刪除現有的產品。',
    'ui_p_edit_description' => "添加產品或修改產品，必須輸入所有帶 * 的項目。\n商品添加后，可以在商品列表頁面選擇“圖片管理”對商品的縮略圖和大圖片進行設置。",
    'ui_p_product_name' => '產品名稱',
    'ui_p_class' => '所屬類別',
    'ui_p_overview' => '產品介紹',
    'ui_p_thumb' => '上傳縮略圖',
    'ui_p_price' => '商品價格',
    'ui_p_price_note' => '只能輸入數值',
    'ui_p_price_units' => '元',
    'ui_p_form_validation' => '所有帶雙 * 號的項目都必須填寫！',
    'ui_p_form_price_validation' => '價格必須輸入數值',
    'ui_p_form_class_validation' => '必須選擇至少一個商品分類',
    'ui_p_remove_confirm' => '您確定要刪除該產品？',
    'ui_p_no_products' => '當前沒有任何產品信息。',
    'ui_p_jump_page' => '第 %u 頁',
    'ui_p_page_info' => '共有信息 <strong>%u</strong> 條，符合檢索條件的共有 <strong>%u</strong> 條記錄，分為 <strong>%u</strong> 頁顯示，當前查看的是第 <strong>%u</strong> 頁',
    'ui_p_price_value' => '￥ %7.2f',
    'ui_p_picman_welcome' => '產品圖片管理',
    'ui_p_picman_description' => '在這里可以修改指定產品的縮略圖，并為產品添加任意多張的大圖片。',
    'ui_p_picman_back' => ' 返 回 ',
    'ui_p_picman_thumb' => '商品縮略圖（寬度 %u 像素，高度 %u 像素）',
    'ui_p_picman_thumb_upload' => '上傳新的縮略圖',
    'ui_p_picman_filename' => '圖片文件名',
    'ui_p_picman_filesize' => '文件大小',
    'ui_p_picman_upload' => ' 上 傳 ',
    'ui_p_picman_thumb_note' => "* 新的縮略圖會替代現有的縮略圖，超過大小的文件會自動裁減",
    'ui_p_picman_photo' => '商品大圖',
    'ui_p_picman_click' => '點擊查看完整圖片',
    'ui_p_picman_remove' => '刪除該圖片',
    'ui_p_picman_photo_upload' => '上傳新的商品大圖',
    'ui_p_picman_remove_confirm' => '您確定要刪除該圖片嗎？',
    'ui_p_picman_form_validation' => '必須選擇要上傳的圖片文件',
    'ui_p_invalid_filetype' => '無效的文件類型',
    'ui_p_upload_failed' => '上傳文件失敗',
	'ui_p_create_class_first' => '請先創建至少一個產品類別',

    /**
     * ui_u - 個人首選項
     */
    'ui_u_change_password_menu' => '修改登錄密碼',
    'ui_u_preference_catalog' => '個人首選項',
    'ui_u_change_password_title' => '修改用戶 %s 的登錄密碼',
    'ui_u_enter_current_password' => '輸入現在使用的登錄密碼：',
    'ui_u_enter_new_password' => '　　　　　　輸入新密碼：',
    'ui_u_enter_new_password_again' => '　　　再輸入一次新密碼：',
    'ui_u_enter_current_password_tip' => '必須輸入現在使用的登錄密碼',
    'ui_u_enter_new_password_tip' => '必須輸入新的登錄密碼',
    'ui_u_enter_new_password_not_match' => '兩次輸入的新密碼不一致',
    'ui_u_change_password_successed' => '密碼修改成功，下次登錄請使用新密碼',

    /**
     * ui_g - 通用信息
     */
    'ui_g_operation' => '操作',
    'ui_g_operation_view' => '查看',
    'ui_g_operation_edit' => '編輯',
    'ui_g_operation_remove' => '刪除',
    'ui_g_operation_picman' => '圖片管理',
    'ui_g_submit' => ' 提 交 ',
    'ui_g_cancel' => ' 取 消 ',
    'ui_p_created' => '創建日期',
    'ui_p_updated' => '最后更新',
);
