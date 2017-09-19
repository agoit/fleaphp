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
     * ui_l - 登录界面
     */
    'ui_l_title' => '登录后台管理',
    'ui_l_welcome' => "
欢迎使用“%s”后台管理系统！

演示用户：admin
演示密码：123456

注意：请确保 upload 目录可以允许 PHP 程序创建新文件。",
    'ui_l_username' => '管理员帐户:',
    'ui_l_password' => '管理员密码:',
    'ui_l_imgcode' => '验证码:',
    'ui_l_login' => ' 登 录 ',
    'ui_l_form_validation' => '必须输入用户名和密码才能登录。',
    'ui_l_logout' => '您已经成功退出了登录。',
    'ui_l_invalid_imgcode' => '您输入的验证码无效，或者验证码已经过期。请重新登录。',
    'ui_l_invalid_username' => '您输入的用户名不存在，请检查后重新登录。',
    'ui_l_invalid_password' => '您输入的密码不正确，请检查后重新登录。',
    'ui_l_languages' => '界面语言:',


    /**
     * ui_w - 欢迎页面
     */
    'ui_w_title' => '后台管理',
    'ui_w_page_welcome' => '后台欢迎页面',
    'ui_w_user' => '用户:',
    'ui_w_logout' => '注销登录',
    'ui_w_menu_create_product' => '添加商品',
    'ui_w_menu_list_product' => '管理商品',
    'ui_w_menu_list_classes' => '商品分类维护',
    'ui_w_catalog_products' => '商品及分类管理',
    'ui_w_welcome' => "欢迎使用 %s 后台管理系统！",
    'ui_w_instruction' => "\n\n请从左边菜单选择要使用的功能。\n\n\n关闭窗口前请务必点击最上方的“注销登录”连接。",
    'ui_w_link_phpinfo' => '查看系统信息',
    'ui_w_languages' => '选择界面语言:',

    /**
     * ui_c - 分类管理界面
     */
    'ui_c_title' => '商品分类维护',
    'ui_c_create' => '添加分类',
    'ui_c_edit' => '修改分类',
    'ui_c_description' => '在这里，您可以查看商品分类列表。也可以添加新分类或者修改、删除现有的分类。',
    'ui_c_edit_description' => '添加分类或修改分类，必须输入分类名称并选择父分类。',
    'ui_c_class_name' => '分类名称',
    'ui_c_child_count' => '所有子分类数',
    'ui_c_current_location' => '当前位置：',
    'ui_c_calc_child_count' => '，该分类共有子分类 %u 个',
    'ui_c_no_subclasses' => '当前分类下没有任何子分类。',
    'ui_c_root_dir' => '根目录',
    'ui_c_parent_class' => '父分类',
    'ui_c_remove_confirm' => '您确定要删除该分类及其所有子分类？',
    'ui_c_operation_list_child' => '查看子分类',
    'ui_c_form_validation' => '必须输入分类名称',
    'ui_c_invalid_parent_id' => '无效的参数：parent_id = %s',
    'ui_c_invalid_class_id' => '无效的参数：class_id = %s',
    'ui_c_new_top_class' => '（创建新的顶级分类）',

    /**
     * ui_p - 产品管理界面
     */
    'ui_p_title' => '产品管理',
    'ui_p_create' => '添加产品',
    'ui_p_edit' => '修改产品',
    'ui_p_description' => '在这里，您可以查看产品列表。也可以添加新产品或者修改、删除现有的产品。',
    'ui_p_edit_description' => "添加产品或修改产品，必须输入所有带 * 的项目。\n商品添加后，可以在商品列表页面选择“图片管理”对商品的缩略图和大图片进行设置。",
    'ui_p_product_name' => '产品名称',
    'ui_p_class' => '所属类别',
    'ui_p_overview' => '产品介绍',
    'ui_p_thumb' => '上传缩略图',
    'ui_p_price' => '商品价格',
    'ui_p_price_note' => '只能输入数值',
    'ui_p_price_units' => '元',
    'ui_p_form_validation' => '所有带双 * 号的项目都必须填写！',
    'ui_p_form_price_validation' => '价格必须输入数值',
    'ui_p_form_class_validation' => '必须选择至少一个商品分类',
    'ui_p_remove_confirm' => '您确定要删除该产品？',
    'ui_p_no_products' => '当前没有任何产品信息。',
    'ui_p_jump_page' => '第 %u 页',
    'ui_p_page_info' => '共有信息 <strong>%u</strong> 条，符合检索条件的共有 <strong>%u</strong> 条记录，分为 <strong>%u</strong> 页显示，当前查看的是第 <strong>%u</strong> 页',
    'ui_p_price_value' => '￥ %7.2f',
    'ui_p_picman_welcome' => '产品图片管理',
    'ui_p_picman_description' => '在这里可以修改指定产品的缩略图，并为产品添加任意多张的大图片。',
    'ui_p_picman_back' => ' 返 回 ',
    'ui_p_picman_thumb' => '商品缩略图（宽度 %u 像素，高度 %u 像素）',
    'ui_p_picman_thumb_upload' => '上传新的缩略图',
    'ui_p_picman_filename' => '图片文件名',
    'ui_p_picman_filesize' => '文件大小',
    'ui_p_picman_upload' => ' 上 传 ',
    'ui_p_picman_thumb_note' => "* 新的缩略图会替代现有的缩略图，超过大小的文件会自动裁减",
    'ui_p_picman_photo' => '商品大图',
    'ui_p_picman_click' => '点击查看完整图片',
    'ui_p_picman_remove' => '删除该图片',
    'ui_p_picman_photo_upload' => '上传新的商品大图',
    'ui_p_picman_remove_confirm' => '您确定要删除该图片吗？',
    'ui_p_picman_form_validation' => '必须选择要上传的图片文件',
    'ui_p_invalid_filetype' => '无效的文件类型',
    'ui_p_upload_failed' => '上传文件失败',
	'ui_p_create_class_first' => '请先创建至少一个产品类别',

    /**
     * ui_u - 个人首选项
     */
    'ui_u_change_password_menu' => '修改登录密码',
    'ui_u_preference_catalog' => '个人首选项',
    'ui_u_change_password_title' => '修改用户 %s 的登录密码',
    'ui_u_enter_current_password' => '输入现在使用的登录密码：',
    'ui_u_enter_new_password' => '　　　　　　输入新密码：',
    'ui_u_enter_new_password_again' => '　　　再输入一次新密码：',
    'ui_u_enter_current_password_tip' => '必须输入现在使用的登录密码',
    'ui_u_enter_new_password_tip' => '必须输入新的登录密码',
    'ui_u_enter_new_password_not_match' => '两次输入的新密码不一致',
    'ui_u_change_password_successed' => '密码修改成功，下次登录请使用新密码',

    /**
     * ui_g - 通用信息
     */
    'ui_g_operation' => '操作',
    'ui_g_operation_view' => '查看',
    'ui_g_operation_edit' => '编辑',
    'ui_g_operation_remove' => '删除',
    'ui_g_operation_picman' => '图片管理',
    'ui_g_submit' => ' 提 交 ',
    'ui_g_cancel' => ' 取 消 ',
    'ui_p_created' => '创建日期',
    'ui_p_updated' => '最后更新',
);
