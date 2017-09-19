<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>FleaPHP</title>
<link href="../Stuff/css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function fnOnSubmit(form) {
	if (form.database.value == '') {
		alert('必须输入数据库名称');
		form.database.focus();
		return false;
	}

	return true;
}
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="315" height="140"><img src="../Stuff/images/f_01.jpg" width="315" height="140" /></td>
    <td width="197" height="140"><img src="../Stuff/images/f_02.jpg" width="197" height="140" /></td>
    <td height="140" valign="top" background="../Stuff/images/f_03.jpg">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="315" valign="top" background="../Stuff/images/f_05.jpg" style="background-repeat: no-repeat;"><img src="../Stuff/images/f_05w.jpg" width="315" height="1" /><br />
      <br />
      <br />
      <br />
      <br />
      <ul class="step">
        <li>运行环境检查</li>
        <li class="step-current">设置安装选项</li>
        <li>开始安装</li>
        <li>完成安装</li>
      </ul></td>
    <td valign="top"><br />
      <br />
      <br />
      <h3>设置安装选项</h3>
      安装 FleaPHP 附带示例运行所需的数据。如果不使用数据库，则部分示例无法运行。<br />
      <br />
      <span class="error">注意：如果已经安装过实例，则再次安装会覆盖掉现有的实例程序数据。</span><br />
      <br />
      <form action="begin-install.php" method="post" name="form1" id="form1" onsubmit="return fnOnSubmit(this);">
        数据库类型：
        <select name="driver">
          <option value="mysql" selected="selected">MySQL 3.x/4.x/5.x</option>
		<!--
          <option value="mysqli">MySQL Improved/PHP5</option>
          <option value="mysqlt">MySql w/transactions</option>
          <option value="postgres">PostgreSQL</option>
          <option value="postgres64">PostgreSQL 6.4</option>
          <option value="postgres7">PostgreSQL 7</option>
          <option value="postgres8">PostgreSQL 8</option>
          <option value="sqlite">SqLite</option>
          <option value="sqlitepo">SqLite Pro</option>
          <option value="mssql">Microsoft SQL</option>
          <option value="mssqlpo">Microsoft SQL Pro</option>
          <option value="sybase">Sybase</option>
          <option value="sybase_ase">SyBase ASE</option>
		  <option value="odbc">ODBC</option>
          <option value="fbsq">Frontbase</option>
          <option value="maxdb">Max DB</option>
          <option value="msql">Mini SQL</option>
		// -->
        </select>
        <br />
        数据库主机：
        <input name="host" type="text" class="inputbox" id="host" value="localhost" />
        <br />
        数据库用户：
        <input name="login" type="text" class="inputbox" id="login" />
        <br />
        数据库密码：
        <input name="password" type="text" class="inputbox" id="password" />
        <br />
        数据库名称：
        <input name="database" type="text" class="inputbox" id="database" />
        <br />
        <br />
        <input name="Next" type="submit" id="Next" value="开始安装 &gt;&gt;" class="button" />
      </form></td>
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
