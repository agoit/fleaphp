<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>FleaPHP</title>
<link href="../Stuff/css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function fnOnSubmit(form) {
	if (form.database.value == '') {
		alert('�����������ݿ�����');
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
        <li>���л������</li>
        <li class="step-current">���ð�װѡ��</li>
        <li>��ʼ��װ</li>
        <li>��ɰ�װ</li>
      </ul></td>
    <td valign="top"><br />
      <br />
      <br />
      <h3>���ð�װѡ��</h3>
      ��װ FleaPHP ����ʾ��������������ݡ������ʹ�����ݿ⣬�򲿷�ʾ���޷����С�<br />
      <br />
      <span class="error">ע�⣺����Ѿ���װ��ʵ�������ٴΰ�װ�Ḳ�ǵ����е�ʵ���������ݡ�</span><br />
      <br />
      <form action="begin-install.php" method="post" name="form1" id="form1" onsubmit="return fnOnSubmit(this);">
        ���ݿ����ͣ�
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
        ���ݿ�������
        <input name="host" type="text" class="inputbox" id="host" value="localhost" />
        <br />
        ���ݿ��û���
        <input name="login" type="text" class="inputbox" id="login" />
        <br />
        ���ݿ����룺
        <input name="password" type="text" class="inputbox" id="password" />
        <br />
        ���ݿ����ƣ�
        <input name="database" type="text" class="inputbox" id="database" />
        <br />
        <br />
        <input name="Next" type="submit" id="Next" value="��ʼ��װ &gt;&gt;" class="button" />
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
