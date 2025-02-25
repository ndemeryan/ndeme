<?php
session_start();
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
    
    <style>
        .profile-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 400px;
    margin: auto;
}

.profile-container img {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
}

.profile-container h2, .profile-container p {
    margin: 10px 0;
}
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="img/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">

        <p><?php echo htmlspecialchars($user['username']); ?></p>
    </div>
</body>
</html>
