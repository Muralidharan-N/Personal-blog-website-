<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE posts SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $description, $status, $post_id, $_SESSION['user_id']]);
    header('Location: manage_post.php');
}

$post_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$post_id, $_SESSION['user_id']]);
$post = $stmt->fetch();

if (!$post) {
    die('Post not found.');
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
    Title: <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    Description: <textarea name="description" required><?php echo htmlspecialchars($post['description']); ?></textarea>
    Status: 
    <select name="status">
        <option value="published" <?php if ($post['status'] == 'published') echo 'selected'; ?>>Published</option>
        <option value="draft" <?php if ($post['status'] == 'draft') echo 'selected'; ?>>Draft</option>
    </select>
    <button type="submit">Update Post</button>
</form>
