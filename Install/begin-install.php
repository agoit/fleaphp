<?php
$host = $_POST['host'];
$login = $_POST['login'];
$password = $_POST['password'];
$database = $_POST['database'];

$log = '';
$continue = false;
do {
    $log .= "�����������ݿ�������";
    if (!@mysql_connect($host, $login, $password)) {
        $log .= "�޷�����\n" . mysql_error();
        break;
    }
    $log .= "�ɹ����ӵ� {$host}\n";

    $log .= "���Դ����ݿ� {$database}��";
    if (!@mysql_select_db($database)) {
        $log .= "���ݿⲻ����\n";
        $log .= "���Խ������ݿ� {$database}��";

        if (!@mysql_query("CREATE DATABASE {$database}")) {
            $log .= "ʧ��\n" .mysql_error();
            break;
        }
        mysql_select_db($database);
        $log .= "�ɹ�\n";
    }

    $rs = mysql_query('SELECT VERSION()');
    $row = mysql_fetch_row($rs);
    $version = $row[0];
    if ($version >= '4.1') {
        $scriptFilename = realpath(dirname(__FILE__) . '/../Stuff/sql/mysql5.sql');
    } else {
        $scriptFilename = realpath(dirname(__FILE__) . '/../Stuff/sql/mysql.sql');
    }

    if (!$scriptFilename) {
        $log .= "�޷��ҵ����ݿ�ű��ļ�\n";
        break;
    }

    $log .= "��ʼִ�����ݿ�ű��ļ�.....\n\n";
    $script = file_get_contents($scriptFilename);
	foreach (explode(';', $script) as $sql) {
	    $sql = trim($sql);
		if ($sql == '') { continue; }
        $log .= $sql . "\n\n";
		if (!@mysql_query($sql)) {
		    $log .= "�ű�ִ�д���" . mysql_error();
			break 2;
		}
	}
	$log .= "\n�ű�ִ����ϡ�\n";

	$log .= "д�������ļ���";
	$configFilename = realpath(dirname(__FILE__) . '/../Example/_Shared/')
	        . DIRECTORY_SEPARATOR . 'DSN.php';
    $log .= $configFilename ."\n";
    if (file_exists($configFilename)) {
        $log .= "* �����ļ��Ѿ����ڣ����ļ��������� *\n";
    }

    $host = "'" . addslashes($host) . "'";
    $login = "'" . addslashes($login) . "'";
    $password = "'" . addslashes($password) . "'";
    $database = "'" . addslashes($database) . "'";

    $config = <<<EOT
<?php

return array(
    'dbDSN' => array(
        'driver'    => 'mysql',
        'host'      => {$host},
        'login'     => {$login},
        'password'  => {$password},
        'database'  => {$database}
    )
);

?>
EOT;
    $fp = fopen($configFilename, 'w');
    if (!$fp) {
        $log .= "����д���ļ�ʧ�ܡ�\n";
        break;
    }

    fwrite($fp, $config);
    fclose($fp);
    $log .= "\nд�������ļ��ɹ�����װ��ɡ�\n";

    $continue = true;
} while (false);

$log .= "\n\n";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>FleaPHP</title>
<link href="../Stuff/css/style.css" rel="stylesheet" type="text/css" />
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
        <li>���ð�װѡ��</li>
        <li class="step-current">��ʼ��װ</li>
        <li>��ɰ�װ</li>
      </ul></td>
    <td valign="top"><br />
      <br />
      <br />
      <h3>��ʼ��װ</h3>
      ����������ʾ�İ�װ���������������ȷ���뷵����һ���������ð�װѡ������ٴΰ�װ��<br />
      <br />
      <textarea name="textarea" style="width: 100%; font-size: 12px;" rows="20" readonly="readonly"><?php echo htmlspecialchars($log); ?></textarea>
      <br />
      <br />
	  <input name="Back" type="button" class="button" id="Back" value="&lt;&lt; �޸İ�װѡ��" onclick="document.location.href='set-options.php';" />
	  &nbsp;&nbsp;
      <input name="Next" type="button" class="button" id="Next" value="��ɰ�װ &gt;&gt;" <?php if (!$continue): ?>disabled="disabled"<?php endif; ?> onclick="document.location.href='complete-install.php';" /></td>
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
