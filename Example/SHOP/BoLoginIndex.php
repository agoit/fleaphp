<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<title><?php echo_h(_T('ui_l_title')); ?></title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function fnOnSubmit(form) {
	if (form.username.value == '' || form.password.value == '') {
		alert('<?php echo t2js(_T('ui_l_form_validation')); ?>');
		return false;
	}
	return true;
}
</script>
</head>
<body>
<div id="window">
  <div id="content">
    <h1><?php echo_h(_T('ui_l_title')); ?></h1>
    <div id="note"><img src="images/login-icon.gif" /><?php echo_t(sprintf(_T('ui_l_welcome'), get_app_inf('appTitle'))); ?>
      <br />
      <?php if (isset($msg)): ?>
      <span class="error-msg"><?php echo_t($msg); ?></span><br />
      <?php endif; ?>
    </div>
    <div id="form"><img src="images/login-title.gif" />
	  <br />
      <br />
      <form name="form1" id="form1" method="post" action="<?php echo url('BoLogin', 'login'); ?>" onsubmit="return fnOnSubmit(this);">
        <label><?php echo_h(_T('ui_l_username')); ?></label>
        <br />
        <?php html_textbox('username', '', 22); ?>
        <br />
        <br />
        <label><?php echo_h(_T('ui_l_password')); ?></label>
        <br />
		<?php html_password('password', '', 22); ?>
        <br />
        <br />
        <label><?php echo_h(_T('ui_l_imgcode')); ?></label>
        <img src="<?php echo $this->_url('imgcode'); ?>" /><br />
		<?php html_textbox('imgcode', '', 22); ?>
        <br />
        <br />
		<label><?php echo_h(_T('ui_l_languages')); ?></label>
		<br />
        <?php html_dropdown_list('language', get_app_inf('languages')); ?>
		<br />
        <br />
        <br />
        <input name="login" type="submit" id="login" value="<?php echo_h(_T('ui_l_login')); ?>" class="button" />
      </form>
    </div>
  </div>
</div>
</body>
</html>
