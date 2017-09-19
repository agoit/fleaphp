<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
function fnOnBack() {
	var url = '<?php echo $this->_getBack(); ?>';
	document.location.href = url;
}

function fnOnRemove() {
	return confirm('<?php echo t2js(_T('ui_p_picman_remove_confirm')); ?>');
}

function fnOnSubmit(form) {
	form.Save.disabled = true;

	if (form.postfile.value == '') {
		alert('<?php echo t2js(_T('ui_p_picman_form_validation')); ?>');
		form.Save.disabled = false;
		return false;
	}

	return true;
}

// -->
</script>
</head>
<body>
<div id="content">
  <h3><?php echo_h(_T('ui_p_picman_welcome')); ?></h3>
  <div class="description"><?php echo_t(_T('ui_p_picman_description')); ?></div>
  <br />
  <?php if (isset($errorMessage)): ?>
  <p class="error-msg"><?php echo $errorMessage; ?></p>
  <?php endif; ?>
  <br />
  <strong><?php echo_h(_T('ui_p_product_name')); ?>:</strong><br />
  <?php echo_h($product['name']); ?><br />
  <br />
  <input name="back" type="button" value="<?php echo_h(_T('ui_p_picman_back')); ?>" onclick="document.location.href = '<?php echo $this->_getBack(); ?>';" />
  <br />
  <br />
  <br />
  <strong><?php echo_h(sprintf(_T('ui_p_picman_thumb'), get_app_inf('thumbWidth'), get_app_inf('thumbHeight'))); ?>:</strong><br />
  <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#DDEEEE">
    <tr>
      <?php if ($product['thumb_filename'] != ''): ?>
      <td width="<?php echo get_app_inf('thumbWidth') + 20; ?>" align="center" valign="middle"><img src="<?php echo get_app_inf('uploadRoot') . '/' . $product['thumb_filename']; ?>" border="0" width="<?php echo get_app_inf('thumbWidth'); ?>" height="<?php echo get_app_inf('thumbHeight'); ?>" /></td>
      <?php endif; ?>
      <td valign="top"><br />
        <?php if ($product['thumb_filename'] != ''): ?>
        <?php echo_h(_T('ui_p_picman_filename')); ?>: <?php echo_h($product['thumb_filename']); ?><br />
        <?php echo_h(_T('ui_p_picman_filesize')); ?>: <?php echo ceil(filesize(get_app_inf('uploadDir') . DS . $product['thumb_filename']) / 1024); ?> KB<br />
        <br />
        <?php endif; ?>
        <form action="<?php echo url($this->_controllerName, 'uploadThumb', array('id' => $product[$pk])); ?>" method="post" enctype="multipart/form-data" name="form2" id="form2" style="margin: 0px; padding: 0px;" onsubmit="return fnOnSubmit(this);">
          <?php echo_h(_T('ui_p_picman_thumb_upload')); ?>:<br />
          <input name="postfile" type="file" size="40" />
          <br />
          <br />
          <input name="Save" type="submit" value="<?php echo_h(_T('ui_p_picman_upload')); ?>" />
          <br />
          <br />
          <span class="red"><?php echo_t(_T('ui_p_picman_thumb_note')); ?></span>
        </form>
        <br /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br />
  <br />
  <strong><?php echo_h(_T('ui_p_picman_photo')); ?>:</strong><br />
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <?php foreach ($product['photos'] as $photo): $href = get_app_inf('uploadRoot') . '/' . $photo['photo_filename']; ?>
    <tr>
      <td width="<?php echo get_app_inf('thumbWidth') + 20; ?>" align="center" valign="middle" class="split_line"><a href="<?php echo $href; ?>" target="_blank"><img src="<?php echo $href; ?>" width="<?php echo get_app_inf('thumbWidth'); ?>" border="0" /></a><br />
        <br />
        <a href="<?php echo $href; ?>" target="_blank"><?php echo_h(_T('ui_p_picman_click')); ?></a></td>
      <td valign="top" class="split_line"><form action="<?php echo url($this->_controllerName, 'removePhoto', array('id' => $product[$pk], 'photo_id' => $photo['photo_id'])); ?>" method="post" name="form3" id="form3" style="margin: 0px; padding: 0px;" onsubmit="return fnOnRemove();">
          <br />
          <?php echo_h(_T('ui_p_picman_filename')); ?>: <?php echo_h($photo['photo_filename']); ?><br />
          <?php echo_h(_T('ui_p_picman_filesize')); ?>: <?php echo ceil(filesize(get_app_inf('uploadDir') . '/' . $photo['photo_filename']) / 1024); ?> KB<br />
          <br />
          <input name="Remove" type="submit" value="<?php echo_h(_T('ui_p_picman_remove')); ?>" />
        </form></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
  </table>
  <table border="0" cellpadding="2" cellspacing="2" bgcolor="#FFCCFF">
    <tr>
      <td><form action="<?php echo url($this->_controllerName, 'uploadPhoto', array('id' => $product[$pk])); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return fnOnSubmit(this);" style="margin: 0px; padding: 0px;">
          <a name="uploadForm" id="uploadForm"></a><?php echo_h(_T('ui_p_picman_photo_upload')); ?>:<br />
          <input name="postfile" type="file" size="40" />
          <br />
          <br />
          <input name="Save" type="submit" value="<?php echo_h(_T('ui_p_picman_upload')); ?>" />
        </form>
        <br />
      </td>
    </tr>
  </table>
  <br />
  <br />
</div>
</body>
</html>
