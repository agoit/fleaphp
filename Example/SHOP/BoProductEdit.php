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

function fnOnSubmit(form) {
	form.Save.disabled = true;
	if (form.name.value == '' ||
		form.overview.value == '' ||
		form.price.value == '')
	{
		alert('<?php echo_h(_T('ui_p_form_validation')); ?>');
		form.Save.disabled = false;
		return false;
	}

	if (isNaN(form.price.value)) {
		alert('<?php echo_h(_T('ui_p_form_price_validation')); ?>');
		form.Save.disabled = false;
		return false;
	}

	var el = form['classes[]'];
	if (el.selectedIndex == -1) {
		alert('<?php echo_h(_T('ui_p_form_class_validation')); ?>');
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
  <h3><?php if ($product['product_id'] == 0): echo_h(_T('ui_p_create')); else: echo_h(_T('ui_p_edit')); endif; ?></h3>
  <div class="description"><?php echo_t(_T('ui_p_edit_description')); ?></div>
  <br />
  <p class="error-msg"><?php echo $errorMessage; ?></p>
  <form action="<?php echo $this->_url('save'); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return fnOnSubmit(this);">
    <span class="error-msg">*&nbsp;</span><strong><?php echo_h(_T('ui_p_product_name')); ?>:</strong><br />
    <?php html_textbox('name', $product['name'], 40, 128); ?>
	<br />
    <br />
    <span class="error-msg">*&nbsp;</span><strong><?php echo_h(_T('ui_p_class')); ?>:</strong><br />
    <select name="classes[]" size="8" multiple="multiple" id="classes[]">
	<?php
	$right = array();
	if (isset($product['classes'])) {
		$selectedClasses = (array)$product['classes'];
	} else {
		$selectedClasses = array();
	}
	foreach ($classes as $class):
        $c = count($right);
		if ($c > 0) {
			while ($c > 0 &&
                $right[$c - 1] < $class['right_value'])
            {
				array_pop($right);
				$c = count($right);
			}
		}
        $className = str_repeat('  ', $c) . $class['name'] . '      ';
		$right[] = $class['right_value'];
	?>
	<option value="<?php echo $class['class_id']; ?>"<?php if (in_array($class['class_id'], $selectedClasses)): ?>selected<?php endif; ?>><?php echo_t($className); ?></option>
	<?php endforeach; ?>
    </select>
    <br />
    <br />
    <span class="error-msg">*&nbsp;</span><strong><?php echo_h(_T('ui_p_overview')); ?>:</strong><br />
    <?php html_textarea('overview', $product['overview'], 59, 8); ?>
    <br />
    <br />
    <span class="error-msg">*&nbsp;</span><strong><?php echo_h(_T('ui_p_price')); ?>:</strong><br />
	<span class="note"><?php echo_h(_T('ui_p_price_note')); ?></span><br />
    <?php html_textbox('price', sprintf('%0.2f', $product['price']), 20, 10); ?><?php echo_t(_T('ui_p_price_units')); ?>
    <br />
    <br />
    <br />
    <input name="Save" type="submit" id="Save" value="<?php echo_h(_T('ui_g_submit')); ?>" />
	&nbsp;&nbsp;
    <input name="Cancel" type="button" id="Cancel" value="<?php echo_h(_T('ui_g_cancel')); ?>" onclick="fnOnBack();" />
    <input name="<?php echo $pk; ?>" type="hidden" id="<?php echo $pk; ?>" value="<?php echo $product[$pk]; ?>" />
  </form>
</div>
</body>
</html>
