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
      <span class="error">����ǰʹ�õ� FleaPHP �汾Ϊ <?php echo FLEA_VERSION; ?>��</span><br />
      <br />
      <?php if ($lastVersion == -1): ?>
      �������� php.ini �� allow_url_fopen ����Ϊ Off�����������������޷���ѯ FleaPHP ���°汾����Ϣ����ע����ʱ�������� FleaPHP �汾��<br />
      <?php elseif ($lastVersion > FLEA_VERSION): ?>
      <span class="error">���µİ汾Ϊ <?php echo $lastVersion; ?>�������������°汾�� </span><br />
      <?php elseif ($lastVersion < FLEA_VERSION): ?>
      ��ʹ�õİ汾����վ�Ͽ������صİ汾���¡� <br />
      <?php else: ?>
      ��ʹ�õ������°汾�� <br />
      <?php endif; ?>
      <br />
      <br />
      FleaPHP Ϊ���������ɡ���ݵĴ���Ӧ�ó����ṩ������FleaPHP ��ܼ򵥡���������������ѧϰ����������ȫ���Ļ����ĵ��ͷḻ��ʾ�����򽵵�ѧϰ�ɱ���ʹ�� FleaPHP ��ܿ�����Ӧ�ó����ܹ��Զ���Ӧ�������л����������� PHP4 �� PHP5��FleaPHP ��ȫ���� Fast-Lightweight-Extensible-Automatic PHP web application framework��<br />
      <br />
      �й� FleaPHP ����ϸ��Ϣ����� <a href="http://www.fleaphp.org/" target="_blank">FleaPHP �ٷ���ҳ</a>��<br />
      <br />
      <br />
      <h3>���� FleaPHP</h3>
      Ҫ���� FleaPHP �ķǷ��������������ȴ� FleaPHP ���е�ʾ������ʼ��FleaPHP �ṩ�˶��ʾ��������Щʾ��������չʾ�� FleaPHP ���Ӧ�����ֲ�ͬ������<br />
      <br />
      <br />
      <h3>ʾ������</h3>
      �������ڳɹ�<a href="Install/index.php">����ʾ������װ��</a>��������������ʾ�����������װ�򵼻�Ϊʾ�������������һЩ׼��������������Ҫ�Ǵ���ʾ��������Ҫ�����ݱ�<br />
      <br />
      ѡ��Ҫ���е�ʾ������<br />
      <table border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/MVC-Basic/index.php" target="_blank">MVC-Basic</a><br />
            ��򵥵�ʾ������ʾ FleaPHP �� MVC ģʽ��</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/MVC-Blog/index.php" target="_blank">MVC-Blog</a><br />
            ��һ���򻯵� Blog ������ʾ FleaPHP �� MVC ģʽ���Զ��������ݿ� CRUD����������ȡ�����¡�ɾ������������ʾ��������ͬ�ȹ��ܵ� Zend Framework �汾��<a href="http://www.phpchina.com/bbs/thread-5820-1-1.html" target="_blank">����鿴</a>��</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/Blog/index.php" target="_blank">Blog</a><br />
            �򵥵� Blog ���򣬿���������ۣ���Ϊ��־��Ŀ���� Tags��</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/Smarty/index.php" target="_blank">Smarty</a><br />
            ��ʾ��ν� FleaPHP �����е� Smarty ģ�����漯��������</td>
        </tr>
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/Shop/index.php" target="_blank">Shop</a><br />
            ���ʾ���Ǵ�һ��ʵ��Ӧ�ó���ĺ�̨�����ּ򻯶�������ʾ�� FleaPHP �ṩ�Ķ�����֧�֡�������޹صĳ����������ݿ�������ļ��ϴ���ͼ�������ݱ������������</td>
        </tr>
        <!--
        <tr>
          <td><img src="Stuff/images/f_demo.jpg" width="24" height="24" /></td>
          <td><a href="Example/TODO/index.php" target="_blank">Todo-Lists</a><br />
          ���ʾ����һ��������Ӧ�ó��򣬴���ͽ���ԭ������ <a href="http://www.37signals.com/" target="_blank">37signals</a> ������ <a href="http://www.tadalist.com/">Ta-Da List</a> Ӧ�ó���</td>
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
