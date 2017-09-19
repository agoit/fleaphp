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
  <h3>查看日志及评论，<a href="<?php echo $this->_url(); ?>">返回首页</a></h3><br />
  <h3><?php echo date('Y-m-d H:i:s', $post['created']) . ' - ' . h($post['title']); ?></h3>
  <?php echo_t($post['body']); ?>
  <br /><br />
  <div class="meta">
  [ <a href="<?php echo $this->_url('edit', array('post_id' => $post['post_id'])); ?>">edit</a> ]
  [ <a href="<?php echo $this->_url('remove', array('post_id' => $post['post_id'])); ?>" onclick="return confirm('您确定要删除该日志条目？');">Remove</a> ]
  [ 评论数：<?php echo $post['comments_count']; ?>，Tags: <?php foreach ($post['tags'] as $tag): ?><a href="<?php echo $this->_url('tag', array('tag_id' => $tag['tag_id'])); ?>"><?php echo_h($tag['label']); ?></a> <?php endforeach; ?>]
  </div>
  <br />
  <?php foreach ($post['comments'] as $comment): ?>
  <strong>评论：<?php echo date('Y-m-d H:i:s', $comment['created']); ?></strong><br />
  <?php echo_t($comment['body']); ?><br />
  <br />
  <?php endforeach; ?>
  <br />
  <form id="form1" method="post" action="<?php echo $this->_url('createComment'); ?>" onsubmit="if (this.body.value == '') { alert('请输入评论内容'); return false; } else { return true; }">
    <strong>添加评论内容：</strong><br />
    <?php html_textarea('body', '', 50, 8); ?>
    <br />
    <br />
    <input type="submit" name="Submit" value="添加评论" />
	<?php html_hidden('post_id', $post['post_id']); ?>
    <br />
  </form>
</div>
</body>
</html>
