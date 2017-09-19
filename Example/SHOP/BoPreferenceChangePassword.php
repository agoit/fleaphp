<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function fnOnSubmit(form) {
	form.Save.disabled = true;

	if (form.old_password.value == '') {
		alert('<?php echo_h(_T('ui_u_enter_current_password_tip')); ?>');
		form.Save.disabled = false;
		return false;
	}

	if (form.new_password.value == '' || form.new_password2.value == '') {
		alert('<?php echo_h(_T('ui_pu_enter_new_password_tip')); ?>');
		form.Save.disabled = false;
		return false;
	}

	if (form.new_password.value != form.new_password2.value) {
		alert('<?php echo_h(_T('ui_u_enter_new_password_not_match')); ?>');
		form.Save.disabled = false;
		return false;
	}

	return true;
}
</script>
</head>
<body>
<div id="content">
  <h3><?php echo_h(sprintf(_T('ui_u_change_password_title'), $user['USERNAME'])); ?></h3>
  <form id="form1" name="form1" method="post" action="<?php echo $this->_url('updatePassword'); ?>" onsubmit="return fnOnSubmit(this);">
    <p><?php echo_h(_T('ui_u_enter_current_password')); ?>
      <input name="old_password" type="password" id="old_password" />
    </p>
    <p><?php echo_h(_T('ui_u_enter_new_password')); ?>
      <input name="new_password" type="password" id="new_password" />
    </p>
    <p><?php echo_h(_T('ui_u_enter_new_password_again')); ?>
      <input name="new_password2" type="password" id="new_password2" />
    </p>
    <p>
      <input name="Save" type="submit" id="Save" value="<?php echo_h(_T('ui_g_submit')); ?>" />
    </p>
  </form>
</div>
</body>
</html>
