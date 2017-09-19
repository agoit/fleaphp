<html>
<head>
</head>
<body>
<h1>发贴</h1>

  <form action="<?php echo url('Post', 'Save'); ?>" method="POST">

  <p>标题:<br /><input type="text" name="title" size="50" /></p>

  <p>内容:<br /><textarea name="content" cols="50" rows="12"></textarea></p>

  <p><input type="submit" value="Add POST" /></p>
</body>

</html>