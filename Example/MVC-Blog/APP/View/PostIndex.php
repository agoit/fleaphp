<html>
<head>
</head>
<body>
<h1>浏览帖子</h1>
<table>
    <tr>
        <th>Id</th>
        <th>标题 </th>
        <th>发帖时间 </th>
    </tr>

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['id']; ?></td>
        <td>
            <a href="<?php echo url('Post', 'View', array('id' => $post['id'])); ?>"><?php echo_h($post['title']); ?></a>
        </td>
        <td><?php echo $post['created']; ?></td>
        <td>
            <a href="<?php echo url('Post', 'Delete', array('id' => $post['id'])); ?>">删除帖子</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
<br />
<br />
<a href="<?php echo url('Post', 'Add'); ?>">添加帖子</a>

</body>
</html>