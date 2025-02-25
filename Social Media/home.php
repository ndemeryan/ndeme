<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'includes/dbh.inc.php';

$query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Timeline</title>

    <style>
body {
    font-family: Arial, sans-serif;
    background-color: gray;
    height: 100vh;
}

.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
}

.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-container input[type="text"],
.form-container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
}

.form-container input[type="text"]:focus,
.form-container input[type="password"]:focus {
    border-color: #007bff;
}

.form-container button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-container button:hover {
    background-color: #0056b3;
}

.form-error {
    color: red;
    margin-bottom: 15px;
    font-size: 14px;
    text-align: center;
}

    </style>
</head>
<body>
    <h1>Welcome to your timeline!</h1>

    <form action="submit_post.php" method="POST" enctype="multipart/form-data">
        <textarea name="content" placeholder="What's on your mind?"></textarea>
        <input type="file" name="image">
        <button type="submit">Post</button>
    </form>
    <a href="profile.php">User Profile</a>
        <a href="messages.php">Messages</a>

    <br><br>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <p><strong><?php echo htmlspecialchars($post['username']); ?></strong> posted:</p>
            <br>
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <br>
            <?php if ($post['image']): ?>
                <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="width: 300px;">
                <br>
            <?php endif; ?>
            <p><em>Posted on: <?php echo $post['created_at']; ?></em></p>
            <br>
        </div>
        <hr>
    <?php endforeach; ?>

    <?php
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$content = $_POST['content'] ?? '';
$image = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    

    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
}


$query = "INSERT INTO posts (user_id, content, image) VALUES (:user_id, :content, :image)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':content', $content);
$stmt->bindParam(':image', $image);
$stmt->execute();

header('Location: home.php');
exit;
?>

</body>
</html>
