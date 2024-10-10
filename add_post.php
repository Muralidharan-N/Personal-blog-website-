<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    if (isset($_FILES['banner']) && $_FILES['banner']['error'] == 0) {
        $banner = 'uploads/' . basename($_FILES['banner']['name']);
        move_uploaded_file($_FILES['banner']['tmp_name'], $banner);
    }

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, banner, description, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $banner, $description, $status]);
    header('Location: manage_post.php');
}
?>

<div class="container">
    <h2>Add New Post</h2>
    <form method="POST" enctype="multipart/form-data">
        Title: <input type="text" name="title" required>
        Banner: <input type="file" name="banner" required>
        Description: <textarea name="description" required></textarea>
        Status: 
        <select name="status">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
        <button type="submit">Add Post</button>
    </form>
</div>
