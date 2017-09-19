<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<title><?php echo get_app_inf('appTitle'); ?><?php echo_h(_T('ui_w_title')); ?></title>
</head>
<frameset rows="64,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="<?php echo url('BoDashboard', 'topnav'); ?>" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frameset cols="180,*" frameborder="no" border="0" framespacing="0">
    <frame src="<?php echo url('BoDashboard', 'sidebar'); ?>" name="leftFrame" scrolling="Yes" noresize="noresize" id="leftFrame" title="leftFrame" />
    <frame src="<?php echo url('BoDashboard', 'welcome'); ?>" name="mainFrame" id="mainFrame" title="mainFrame" />
  </frameset>
</frameset>
<noframes>
<body>
</body>
</noframes>
</html>
