<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    exit('Unauthorized access.');
}

$host = 'localhost';
$dbname = 'db_55015176'; 
$dbUsername = '55015176'; 
$dbPassword = '55015176'; 

$username = $_POST['username'] ?? ''; // Get the username to delete

if (!$username) {
    header('Location: admin_dashboard.php');
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare deletion query
    $stmt = $pdo->prepare("DELETE FROM users WHERE username = ?");
    $stmt->execute([$username]);

    // Redirect back to admin dashboard with a message
    header('Location: admindashboard.php?message=User+Deleted');
} catch (PDOException $e) {
    die("Error connecting to DB: " . $e->getMessage());
}
?>
