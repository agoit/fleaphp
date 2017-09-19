<?php
define('SHARED_CONFIG_DIR', realpath(dirname(__FILE__) . '/../Example/_Shared/'));

// 检查服务器环境
$continue = true;
$serverEnv = array();

// 检查基本要求
$serverEnv['phpversion'] = phpversion() >= '4.3';
$continue = $continue && $serverEnv['phpversion'];

$serverEnv['mysql'] = function_exists('mysql_connect');
$continue = $continue && $serverEnv['mysql'];

$sharedConfigFilename =  SHARED_CONFIG_DIR . DIRECTORY_SEPARATOR . 'DSN.php';
$serverEnv['configPath'] = $sharedConfigFilename;
if (is_writable(SHARED_CONFIG_DIR)) {
	if (file_exists($sharedConfigFilename)) {
		if (is_writable($sharedConfigFilename)) {
			$serverEnv['writeConfig'] = '覆盖现有';
		} else {
			$serverEnv['writeConfig'] = '只读';
			$continue = false;
		}
	} else {
		$serverEnv['writeConfig'] = '新创建';
	}
} else {
	$serverEnv['writeConfig'] = '目录不可写';
	$continue = false;
}

// 检查推荐设置
$recommendSettings = array(
	array('Safe Mode',            'safe_mode',            false),
	array('Display Errors',       'display_errors',       true),
	array('File Uploads',         'file_uploads',         true),
	array('Magic Quotes GPC',     'magic_quotes_gpc',     false),
	array('Magic Quotes Runtime', 'magic_quotes_runtime', false),
	array('Register Globals',     'register_globals',     false),
	array('Output Buffering',     'output_buffering',     true),
	array('Session auto start',   'session.auto_start',   false)
);

$currentSettings = array();
foreach ($recommendSettings as $setting) {
	$currentSettings[] = array(
		$setting[0],
		$setting[2] ? 'ON' : 'OFF',
		ini_get($setting[1]) ? 'ON' : 'OFF',
		ini_get($setting[1]) == $setting[2]
	);
}

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
        <li class="step-current">运行环境检查</li>
        <li>设置安装选项</li>
		<li>开始安装</li>
        <li>完成安装</li>
      </ul></td>
    <td valign="top"><br />
      <br />
      <br />
      <h3>基本运行环境检查</h3>
      如果下方列表有任何一项未能满足要求，将无法运行 FleaPHP。请在继续安装之前解决所有问题。<br />
      <br />
      PHP 版本 &gt;= 4.3.0：
      <?php if ($serverEnv['phpversion']): ?>
      <span class="ok"><?php echo phpversion() ?></span>
      <?php else: ?>
      <span class="error"><?php echo phpversion() ?></span>
      <?php endif; ?>
      <br />
      MySQL 支持：
      <?php if ($serverEnv['mysql']): ?>
      <span class="ok">可用</span>
      <?php else: ?>
      <span class="error">不支持</span>
      <?php endif; ?>
      <br />
      写入配置文件：
      <?php if ($serverEnv['writeConfig'] == '目录不可写' || $serverEnv['writeConfig'] == '只读'): ?>
      <span class="error"><?php echo htmlspecialchars($serverEnv['writeConfig']); ?></span>
      <?php else: ?>
      <span class="ok"><?php echo htmlspecialchars($serverEnv['writeConfig']); ?></span>
      <?php endif ?>
      <br />
      配置文件路径：<?php echo htmlspecialchars($serverEnv['configPath']); ?><br />
      <br />
      <br />
      <h3>推荐的设置</h3>
      如果您的运行环境设置与推荐设置完全符合，那么可以获得最佳的运行效果和性能表现。<br />
      <br />
      <table border="0" cellpadding="4" cellspacing="1" bgcolor="#666666">
        <tr>
          <td bgcolor="#597380"><span class="white">选项</span></td>
          <td align="center" bgcolor="#597380"><span class="white">推荐设置</span></td>
          <td align="center" bgcolor="#597380"><span class="white">当前设置</span></td>
        </tr>
        <?php foreach ($currentSettings as $setting): ?>
        <tr>
          <td bgcolor="#AFC4CF"><?php echo $setting[0] ?></td>
          <td align="center" bgcolor="#AFC4CF" class="ok"><?php echo $setting[1] ?></td>
          <td align="center" bgcolor="#AFC4CF"><?php if ($setting[3]): ?>
            <span class="ok"><?php echo $setting[2] ?></span>
            <?php else: ?>
            <span class="not-recommend"><?php echo $setting[2] ?></span>
            <?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <br />
      <input name="Next" type="button" id="Next" value="设置安装选项 &gt;&gt;" class="button" <?php if (!$continue): ?>disabled="disabled"<?php endif; ?> onclick="document.location.href='set-options.php';" />
    </td>
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
