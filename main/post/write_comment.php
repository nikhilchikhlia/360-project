<?php
session_start();

// Check if the user is logged in

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

} else {
    header("Location: login-message.html");
}

$host = 'localhost';
$dbname = 'db_55015176'; 
$dbUsername = '55015176'; 
$dbPassword = '55015176';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //retrieve data from POST request
    $threadUser = $_SESSION['username'];
    $posttext = $_POST['comment-text'];
    $postid = $_GET['postid'];

    $sql = "INSERT INTO threads (threaduser, posttext, parentid) VALUES (:threaduser, :posttext, :parentid)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':threaduser', $threadUser);
    $stmt->bindParam(':posttext', $posttext);
    $stmt->bindParam(':parentid', $postid);

    $stmt->execute();

    echo "Comment successfully created!";
    header("Location: post.html");
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>