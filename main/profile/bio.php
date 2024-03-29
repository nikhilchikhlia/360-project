<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'db_55015176'; 
$dbUsername = '55015176'; 
$dbPassword = '55015176'; 

if (!isset($_SESSION['username'])) {
    echo "You must be logged in to update your bio.";
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bio'])) {
        $bio = $_POST['bio'];
        $username = $_SESSION['username']; 

       
        $sql = "UPDATE profile SET bio = :bio WHERE userprofile = :userprofile";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['bio' => $bio, 'userprofile' => $username]);

        echo "Bio updated successfully.";
        
    }
} catch (PDOException $e) {
    die("Error connecting to DB: " . $e->getMessage());
}
?>
