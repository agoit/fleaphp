<?php
require('FLEA/FLEA.php');
__FLEA_PREPARE();

@session_start();
if (!isset($_SESSION['FLEAPHP_LAST_VERSION'])) {
    $lastVersion = trim(@file_get_contents('http://www.fleaphp.org/downloads/LastVersion.txt'));
	if ($lastVersion == '') {
		$lastVersion = -1;
	}
    $_SESSION['FLEAPHP_LAST_VERSION'] = $lastVersion;
} else {
    $lastVersion = $_SESSION['FLEAPHP_LAST_VERSION'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>FleaPHP</title>
<link href="Stuff/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="315" height="140" valign="bottom" bgcolor="#FFFFFF"><img src="Stuff/images/f_01.jpg" width="315" height="140" /></td>
    <td width="197" height="140" valign="bottom" bgcolor="#FFFFFF"><img src="Stuff/images/f_02.jpg" width="197" height="140" /></td>
    <td height="140" valign="top" background="Stuff/images/f_03.jpg" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="315" valign="top"><img src="Stuff/images/f_05.jpg" width="315" height="209" /></td>
    <td valign="top"><br />
      <br />
      <span class="error">您当前使用的 FleaPHP 版本为 <?php echo FLEA_VERSION; ?>。</span><br />
      <br />
      <?php if ($lastVersion == -1): ?>
      由于您的 php.ini 中 allow_url_fopen 设置为 Off，或者网络错误。因此无法查询 FleaPHP 最新版本的信息。请注意随时更新您的 FleaPHP 版本。<br />
      <?php elseif ($lastVersion > FLEA_VERSION): ?>
      <span class="error">最新的版本为 <?php echo $lastVersion; ?>，请升级到最新版本。 </span><br />
      <?php elseif ($lastVersion < FLEA_VERSION): ?>
      您使用的版本比网站上可以下载的版本更新。 <br />
      <?php else: ?>
      您使用的是最新版本。 <br />
      <?php endif; ?>
      <br />
      <br />
      FleaPHP 为开发者轻松、快捷的创建应用程序提供帮助。FleaPHP 框架简单、清晰，容易理解和学习，并且有完全中文化的文档和丰富的示例程序降低学习成本。使用 FleaPHP 框架开发的应用程序能够自动适应各种运行环境，并兼容 PHP4 和 PHP5。FleaPHP 的全名是 Fast-Lightweight-Extensible-Automatic PHP web application framework。<br />
      <br />
      有关 FleaPHP 的详细信息请访问 <a href="http://www.fleaphp.org/" target="_blank">FleaPHP 官方主页</a>。<br />
      <br />
      <br />
      <h3>体验 FleaPHP</h3>
      要体验 FleaPHP 的非凡魅力，可以首先从 FleaPHP 带有的示例程序开始。FleaPHP 提供了多个示例程序。这些示例程序充分展示了 FleaPHP 如何应付各种不同的需求。<br />
      <br />
      <br />
      <h3>示例程序</h3>
      您必须在成功<a href="Install/index.php">运行示例程序安装向导</a>后才能运行下面的示例程序。这个安装向导会为示例程序的运行做一些准备工作，其中主要是创建示例程序需要的数据表。<br />
      <br />
      选择要运行的示例程序<br />
      <table border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/MVC-Basic/index.php" target="_blank">MVC-Basic</a><br />
            最简单的示例，演示 FleaPHP 中 MVC 模式。</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/MVC-Blog/index.php" target="_blank">MVC-Blog</a><br />
            用一个简化的 Blog 程序演示 FleaPHP 的 MVC 模式和自动化的数据库 CRUD（创建、读取、更新、删除）操作。该示例程序还有同等功能的 Zend Framework 版本，<a href="http://www.phpchina.com/bbs/thread-5820-1-1.html" target="_blank">点击查看</a>。</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/Blog/index.php" target="_blank">Blog</a><br />
            简单的 Blog 程序，可以添加评论，并为日志条目加上 Tags。</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/Smarty/index.php" target="_blank">Smarty</a><br />
            演示如何将 FleaPHP 和流行的 Smarty 模版引擎集成起来。</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/Shop/index.php" target="_blank">Shop</a><br />
            这个示例是从一个实际应用程序的后台管理部分简化而来。演示了 FleaPHP 提供的多语言支持、与编码无关的程序代码和数据库操作、文件上传、图像处理、数据表关联等特征。</td>
        </tr>
        <!--
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/TODO/index.php" target="_blank">Todo-Lists</a><br />
          这个示例是一个完整的应用程序，创意和界面原型来自 <a href="http://www.37signals.com/" target="_blank">37signals</a> 开发的 <a href="http://www.tadalist.com/">Ta-Da List</a> 应用程序。</td>
        </tr>
        // -->
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    <td width="16%" valign="top">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="315" height="80">&nbsp;</td>
    <td class="copyright"><br />
      <br />
      Copyright (c) 2005 - 2006 FleaPHP.org (<a href="http://www.fleaphp.org/" target="_blank" class="copyright">http://www.fleaphp.org/</a>)</td>
  </tr>
</table>
</body>
</html>
