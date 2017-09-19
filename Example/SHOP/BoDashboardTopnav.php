<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function fnOnLanguageChanged(lang) {
	var url = '<?php echo $this->_url('changeLang'); ?>&lang=' + lang;
	parent.document.location.href = url;
}
</script>
</head>
<body>
<div id="topnav">
  <h3>"<?php echo get_app_inf('appTitle'); ?>" <?php echo_h(_T('ui_w_title')); ?></h3>
  <div id="topnav_menu"> [<a href="<?php echo url('BoDashboard', 'welcome'); ?>" target="mainFrame"><?php echo_h(_T('ui_w_page_welcome')); ?></a>]
    &nbsp;&nbsp;
    [<a href="<?php echo url('BoPreference', 'changePassword'); ?>" target="mainFrame"><?php echo_h(_T('ui_w_user')); ?>&nbsp;<?php echo $user['USERNAME']; ?></a>]
    &nbsp;&nbsp;
    [<a href="<?php echo url('BoLogin', 'logout'); ?>" target="_parent"><?php echo_h(_T('ui_w_logout')); ?></a>]
    &nbsp;&nbsp;<?php echo_h(_T('ui_w_languages')); ?>
    <?php html_dropdown_list('language', get_app_inf('languages'), get_app_inf('defaultLanguage'), "onchange='fnOnLanguageChanged(this.value);'"); ?>
  </div>
</div>
</body>
</html>
