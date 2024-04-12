<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'db_55015176'; 
$dbUsername = '55015176'; 
$dbPassword = '55015176';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $postid = $_GET['postid'];

    $sql = "SELECT threaduser, posttext FROM threads WHERE parentid = $postid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>