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
  <h3>修改日志条目：</h3>
  <form id="form1" method="post" action="<?php echo $this->_url('update'); ?>">
    标题：<br />
    <?php html_textbox('title', $post['title'], 60); ?>
    <br />
    内容：<br />
    <?php html_textarea('body', $post['body'], 59, 15); ?>
    <br />
    Tags（多个标签之间用“,”分隔）：<br />
    <?php html_textbox('tags', $tags, 60); ?>
    <?php html_hidden('post_id', $post['post_id']); ?>
    <br />
    <br />
    <input type="submit" name="Submit" value="更新日志" />
    &nbsp;
    <input name="Cancel" type="button" id="Cancel" value="取消" onclick="document.location.href='<?php echo $this->_url(); ?>';" />
    <br />
  </form>
</div>
</body>
</html>
