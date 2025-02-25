<?php
session_start();
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender, :receiver, :message)");
        $stmt->execute(['sender' => $user_id, 'receiver' => $receiver_id, 'message' => $message]);
    }
}

$stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = :id OR receiver_id = :id");
$stmt->execute(['id' => $user_id]);
$messages = $stmt->fetchAll();

$search_term = $_GET['search'] ?? '';
$search_stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :search AND id != :id");
$search_stmt->execute(['search' => "%$search_term%", 'id' => $user_id]);
$users = $search_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        ul {
    list-style: none;
    padding: 0;
}

li {
    background-color: #fff;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

textarea {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
    </style>
</head>
<body>
    <h2>Messages</h2>

    <form action="messages.php" method="GET">
        <input type="text" name="search" placeholder="Search users" value="<?php echo htmlspecialchars($search_term); ?>">
        <button type="submit">Search</button>
    </form>

    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="messages.php?receiver_id=<?php echo $user['id']; ?>">
                    <?php echo htmlspecialchars($user['username']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul>
        <?php foreach ($messages as $message): ?>
            <li><?php echo htmlspecialchars($message['message']); ?> (<?php echo htmlspecialchars($message['sent_at']); ?>)</li>
        <?php endforeach; ?>
    </ul>

    <form action="messages.php" method="POST">
        <input type="hidden" name="receiver_id" value="<?php echo $_GET['receiver_id'] ?? ''; ?>">
        <textarea name="message" placeholder="Write a message"></textarea>
        <button type="submit">Send</button>
    </form>
</body>
</html>
