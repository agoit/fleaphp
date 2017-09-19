<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="content">
  <h3><?php echo_h(sprintf(_T('ui_w_welcome'), get_app_inf('appTitle'))); ?></h3>
  <p><?php echo_t(_T('ui_w_instruction')); ?></p>
    <?php if ($enablePhpinfo): ?>
    <p><a href="<?php echo $this->_url('phpinfo'); ?>"><?php echo_h(_T('ui_w_link_phpinfo')); ?></a></p>
    <?php endif; ?>
</div>
</body>
</html>
