<html>
<head>
</head>
<body>
<h1>�������</h1>
<table>
    <tr>
        <th>Id</th>
        <th>���� </th>
        <th>����ʱ�� </th>
    </tr>

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['id']; ?></td>
        <td>
            <a href="<?php echo url('Post', 'View', array('id' => $post['id'])); ?>"><?php echo_h($post['title']); ?></a>
        </td>
        <td><?php echo $post['created']; ?></td>
        <td>
            <a href="<?php echo url('Post', 'Delete', array('id' => $post['id'])); ?>">ɾ������</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
<br />
<br />
<a href="<?php echo url('Post', 'Add'); ?>">�������</a>

</body>
</html>