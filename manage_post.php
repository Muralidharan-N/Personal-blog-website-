<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

$user_id = $_SESSION['user_id'];
$posts = $pdo->prepare("SELECT * FROM posts WHERE user_id = ?");
$posts->execute([$user_id]);
?>

<a href="add_post.php">Add New Post</a>
<table>
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Created Date</th>
        <th>Actions</th>
    </tr>
    <?php while ($post = $posts->fetch()): ?>
    <tr>
        <td><?php echo htmlspecialchars($post['title']); ?></td>
        <td><?php echo htmlspecialchars($post['status']); ?></td>
        <td><?php echo $post['created_at']; ?></td>
        <td>
            <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
            <a href="delete_post.php?id=<?php echo $post['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
