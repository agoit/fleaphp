<?php if (!defined('APP_DIR')) { header('Location: index.php'); exit; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Blog</title>
<link href="../../Stuff/css/example-style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="banner"><img src="../../Stuff/images/f_banner.jpg" /></div>
<div id="content">
  <h3>所有指定了 Tag：<?php echo_h($tag['label']); ?> 的日志，<a href="<?php echo $this->_url(); ?>">返回首页</a></h3>
  <?php foreach ($posts as $post): ?>
  <strong><a href="<?php echo $this->_url('view', array('post_id' => $post['post_id'])); ?>"><?php echo date('Y-m-d H:i:s', $post['created']) . ' - ' . h($post['title']); ?></a></strong>
  <br />
  <?php endforeach; ?>
  <br />
</div>
</body>
</html>
