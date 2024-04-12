<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    echo "You must be logged in as an admin to view this page.";
    exit;
}

$host = 'localhost';
$dbname = 'db_55015176'; 
$dbUsername = '55015176'; 
$dbPassword = '55015176'; 

$users = []; // Initialize an empty array to hold user data
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Get search query from URL parameters

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT username, email, first_name, last_name FROM users WHERE username LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => '%' . $search . '%']); // Use LIKE for partial matches
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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class='users-container'>
        <a href="logout.php" class="logout-btn">Log Out</a> <!-- Logout Link -->
        <form action="" method="get">
            <input type="text" name="search" placeholder="Search by username" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <?php foreach ($users as $user): ?>
            <div class='user'>
                <p>Username: <?= htmlspecialchars($user['username']) ?></p>
                <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                <p>Name: <?= htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) ?></p>
                <form action="deleteuser.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    <input type="hidden" name="username" value="<?= htmlspecialchars($user['username']) ?>">
                    <button type="submit">Delete Account</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>