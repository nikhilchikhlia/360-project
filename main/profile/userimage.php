<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'testing'; // Make sure the database name is correct
$dbUsername = 'root'; // Your database username
$dbPassword = ''; // Your database password

if (!isset($_SESSION['username'])) {
    echo "You must be logged in to update your image.";
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image-upload'])) {
        $username = $_SESSION['username']; // Assuming this is the logged-in user's username
        $imageContent = file_get_contents($_FILES['image-upload']['tmp_name']);

        // Use `userprofile` as the column name for username
        $sql = "UPDATE profile SET image = :image WHERE userprofile = :userprofile";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':image', $imageContent, PDO::PARAM_LOB);
        $stmt->bindParam(':userprofile', $username);
        $stmt->execute();

        echo "Image updated successfully.";
        // Redirect or further action
    }
} catch (PDOException $e) {
    die("Error connecting to DB: " . $e->getMessage());
}
?>
