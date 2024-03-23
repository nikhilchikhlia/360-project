<?php
session_start();

// Check if the user is logged in

if(isset($_SESSION['loggedin']) && $_SESSION[loggedin] == true) {

} else {
    heading("Location: login-message.html");
}

// Assuming you've already connected to your database above this point
$host = 'localhost';
$dbname = 'testing';
$dbUsername = 'root';
$dbPassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve data from POST request
    $title = $_POST['post-title'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Capture the category from the form
    $postUser = $_SESSION['username']; // Assuming username stored in session
    
    $fileContent = null;
    if (isset($_FILES['img-upload']) && $_FILES['img-upload']['error'] == 0) {
        // Read the file content
        $fileContent = file_get_contents($_FILES['img-upload']['tmp_name']);
    }

    // SQL statement to insert the new post, including the category
    $sql = "INSERT INTO posts (title, image, description, postuser, category) VALUES (:title, :image, :description, :postuser, :category)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':image', $fileContent, PDO::PARAM_LOB); // Assuming BLOB storage for the image
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':postuser', $postUser);
    $stmt->bindParam(':category', $category);

    // Execute the statement
    $stmt->execute();

    echo "Post created successfully!";
    header("Location: ../landing/landing.html");
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
