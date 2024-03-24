<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'testing'; // Specify your database name here
$dbUsername = 'root'; // Specify your database username here (e.g., 'root')
$dbPassword = ''; // Specify your database password here

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You must be logged in to update your profile.";
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the username from the session
    $username = $_SESSION['username'];

    // Check if a profile already exists for the user
    $checkStmt = $pdo->prepare("SELECT * FROM profile WHERE userprofile = :username");
    $checkStmt->execute([':username' => $username]);
    if ($checkStmt->rowCount() == 0) {
        // Insert the new profile entry if it does not exist
        $sql = "INSERT INTO profile (userprofile) VALUES (:username)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        echo "Profile created for user: " . htmlspecialchars($username);
    } else {
        echo htmlspecialchars($username);
    }
} catch (PDOException $e) {
    die("Error connecting to DB: " . $e->getMessage());
}
?>
