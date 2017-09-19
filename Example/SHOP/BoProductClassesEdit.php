<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
function fnOnSubmit(form) {
	if (form.name.value == '') {
		alert('<?php echo_h(_T('ui_c_form_validation')); ?>');
		form.name.focus();
		return false;
	}
	
	return true;
}
// -->
</script>
</head>
<body>
<div id="content">
  <h3><?php if ($class['class_id'] == 0): echo_h(_T('ui_c_create')); else: echo_h(_T('ui_c_edit')); endif; ?></h3>
  <div class="description"><?php echo_t(_T('ui_c_edit_description')); ?></div>
  <?php if (isset($errorMessage)): ?>
  <div class="error-msg"><?php echo_h($errorMessage); ?></div>
  <?php endif; ?>
  <form action="<?php echo $this->_url('save'); ?>" method="post" onsubmit="return fnOnSubmit(this);">
    <span class="error-msg">*&nbsp;</span><strong><?php echo_h(_T('ui_c_class_name')); ?>:</strong><br />
    <?php html_textbox('name', $class['name']); ?>
    <br />
    <br />
    <strong><?php echo_h(_T('ui_c_parent_class')); ?>:</strong><br />
	<?php echo_h(_T('ui_c_root_dir')); ?><br />
	<?php $level = 1; foreach ($path as $part): ?><?php echo_t(str_repeat('   ', $level) . '+- ' . $part['name']); ?><br /><?php $level++; endforeach; ?>
    <br />
    <br />
    <br />
    <?php html_hidden('class_id', $class['class_id']); ?>
	<?php html_hidden('parent_id', $parent['class_id']); ?>
    <input type="submit" name="Submit" value="<?php echo_h(_T('ui_g_submit')); ?>" />
    &nbsp;&nbsp;
    <input name="Cancel" type="button" id="Cancel" value="<?php echo_h(_T('ui_g_cancel')); ?>" onclick="document.location.href = '<?php echo $this->_getBack(); ?>';"/>
  </form>
</div>
</body>
</html>
