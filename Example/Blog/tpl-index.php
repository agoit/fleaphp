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
  <?php foreach ($posts as $post): ?>
  <h3><a href="<?php echo $this->_url('view', array('post_id' => $post['post_id'])); ?>"><?php echo date('Y-m-d H:i:s', $post['created']) . ' - ' . h($post['title']); ?></a></h3>
  <?php echo_t($post['body']); ?>
  <br /><br />
  <div class="meta">
  [ <a href="<?php echo $this->_url('edit', array('post_id' => $post['post_id'])); ?>">edit</a> ]
  [ <a href="<?php echo $this->_url('remove', array('post_id' => $post['post_id'])); ?>" onclick="return confirm('您确定要删除该日志条目？');">Remove</a> ]
  [ 评论数：<?php echo $post['comments_count']; ?>，Tags: <?php foreach ($post['tags'] as $tag): ?><a href="<?php echo $this->_url('tag', array('tag_id' => $tag['tag_id'])); ?>"><?php echo_h($tag['label']); ?></a> <?php endforeach; ?>]
  </div>
  <br />
  <br />
  <?php endforeach; ?>
  <br />
  <form id="form1" method="post" action="<?php echo $this->_url('create'); ?>" onsubmit="if (this.title.value == '' || this.body.value == '') { alert('请输入日志标题和内容'); return false; } else { return true; }">
    标题：<br />
    <?php html_textbox('title', '', 50); ?>
    <br />
    内容：<br />
    <?php html_textarea('body', '', 50, 8); ?>
    <br />
    Tags（多个标签之间用“,”分隔）：<br />
    <?php html_textbox('tags', '', 50); ?>
    <br />
    现有的标签：<br />
    <?php foreach ($tags as $tag): ?>
    <a href="<?php echo $this->_url('tag', array('tag_id' => $tag['tag_id'])); ?>"><?php echo_h($tag['label']); ?></a>
    <?php endforeach; ?>
    <br />
    <br />
    <input type="submit" name="Submit" value="添加日志" />
    <br />
  </form>
</div>
</body>
</html>
