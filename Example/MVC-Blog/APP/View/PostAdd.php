<html>
<head>
</head>
<body>
<h1>����</h1>

  <form action="<?php echo url('Post', 'Save'); ?>" method="POST">

  <p>����:<br /><input type="text" name="title" size="50" /></p>

  <p>����:<br /><textarea name="content" cols="50" rows="12"></textarea></p>

  <p><input type="submit" value="Add POST" /></p>
</body>

</html>