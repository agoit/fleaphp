<?php
$host = $_POST['host'];
$login = $_POST['login'];
$password = $_POST['password'];
$database = $_POST['database'];

$log = '';
$continue = false;
do {
    $log .= "尝试连接数据库主机：";
    if (!@mysql_connect($host, $login, $password)) {
        $log .= "无法连接\n" . mysql_error();
        break;
    }
    $log .= "成功连接到 {$host}\n";

    $log .= "尝试打开数据库 {$database}：";
    if (!@mysql_select_db($database)) {
        $log .= "数据库不存在\n";
        $log .= "尝试建立数据库 {$database}：";

        if (!@mysql_query("CREATE DATABASE {$database}")) {
            $log .= "失败\n" .mysql_error();
            break;
        }
        mysql_select_db($database);
        $log .= "成功\n";
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
        $log .= "无法找到数据库脚本文件\n";
        break;
    }

    $log .= "开始执行数据库脚本文件.....\n\n";
    $script = file_get_contents($scriptFilename);
	foreach (explode(';', $script) as $sql) {
	    $sql = trim($sql);
		if ($sql == '') { continue; }
        $log .= $sql . "\n\n";
		if (!@mysql_query($sql)) {
		    $log .= "脚本执行错误：" . mysql_error();
			break 2;
		}
	}
	$log .= "\n脚本执行完毕。\n";

	$log .= "写入配置文件：";
	$configFilename = realpath(dirname(__FILE__) . '/../Example/_Shared/')
	        . DIRECTORY_SEPARATOR . 'DSN.php';
    $log .= $configFilename ."\n";
    if (file_exists($configFilename)) {
        $log .= "* 配置文件已经存在，该文件将被覆盖 *\n";
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
        $log .= "尝试写入文件失败。\n";
        break;
    }

    fwrite($fp, $config);
    fclose($fp);
    $log .= "\n写入配置文件成功。安装完成。\n";

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
        <li>运行环境检查</li>
        <li>设置安装选项</li>
        <li class="step-current">开始安装</li>
        <li>完成安装</li>
      </ul></td>
    <td valign="top"><br />
      <br />
      <br />
      <h3>开始安装</h3>
      请检查下面显示的安装结果。如果结果不正确，请返回上一步重新设置安装选项并尝试再次安装。<br />
      <br />
      <textarea name="textarea" style="width: 100%; font-size: 12px;" rows="20" readonly="readonly"><?php echo htmlspecialchars($log); ?></textarea>
      <br />
      <br />
	  <input name="Back" type="button" class="button" id="Back" value="&lt;&lt; 修改安装选项" onclick="document.location.href='set-options.php';" />
	  &nbsp;&nbsp;
      <input name="Next" type="button" class="button" id="Next" value="完成安装 &gt;&gt;" <?php if (!$continue): ?>disabled="disabled"<?php endif; ?> onclick="document.location.href='complete-install.php';" /></td>
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
