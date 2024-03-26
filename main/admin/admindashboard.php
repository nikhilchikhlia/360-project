<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    echo "You must be logged in as an admin to view this page.";
    exit;
}

$host = 'localhost';
$dbname = 'testing';
$dbUsername = 'root';
$dbPassword = '';

$users = []; // Initialize an empty array to hold user data
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT username, email, first_name, last_name FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error connecting to DB: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class='users-container'>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <div class='user'>
                    <p>Username: <?= htmlspecialchars($user['username']) ?></p>
                    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                    <p>Name: <?= htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= isset($error_message) ? $error_message : "No users found." ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
