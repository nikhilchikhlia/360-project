<?php
session_start();

// Replace 'root' and '' with your actual database username and password
$pdo = new PDO('mysql:host=localhost;dbname=testing', 'root', '');

if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT image FROM profile WHERE userprofile = ?");
    $stmt->execute([$_SESSION['username']]);
    $image = $stmt->fetchColumn();

    if ($image) {
        // Assuming the image is stored in JPEG format
        header('Content-Type: image/jpeg');
        echo $image;
        header("Location: profile.html");

    } else {
        // If no image is found, you can choose to display a placeholder or send a default image
        header('Content-Type: image/png');
        // Adjust the path to point to a real placeholder image on your server
        // Example: echo file_get_contents('path/to/placeholder.png');
        // For simplicity, we'll not output anything here
    }
} else {
    // If the user is not logged in, output a placeholder or handle accordingly
    // This example will simply terminate without output
}
?>
