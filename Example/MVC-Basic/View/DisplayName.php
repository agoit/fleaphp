<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>MVC-Basic</title>
<link href="../../Stuff/css/example-style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="banner"><img src="../../Stuff/images/f_banner.jpg" /></div>
<div id="content">
  <strong>程序执行输出结果：</strong> <?php echo_h($name); ?>
  <br />
  <br />
  <br />
  Controller: <?php echo_h(realpath(dirname(__FILE__) . '/../Controller/Default.php')); ?><br />
  Model: <?php echo_h(realpath(dirname(__FILE__) . '/../Model/SayName.php')); ?><br />
  View: <?php echo_h(__FILE__); ?><br />
  <br />
  图示：FleaPHP 中的 MVC 模式实现<br />
  <img src="../../Stuff/images/MVC-Basic-figure-01.jpg" width="335" height="361" /></div>
</body>
</html>
