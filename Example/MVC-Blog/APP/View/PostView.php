<html>
<head>
</head>
<body>

<h1><?php echo_h($post['title']);?></h1>

<p><small>Created: <?php echo $post['created'];?></small></p>

<p><?php echo_t($post['body']); ?></p>
<a href="<?php echo url('Post', 'Index'); ?>">Ìø»ØÊ×Ò³</a>
</body>
</html>