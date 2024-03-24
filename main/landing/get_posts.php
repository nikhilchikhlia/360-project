<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'testing';
$dbUsername = 'root';
$dbPassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT title, IFNULL(image, '') AS image, description, postuser, category, time FROM posts";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert image BLOB to base64 for JSON encoding
    foreach ($posts as $key => $post) {
        if (!empty($post['image'])) {
            $posts[$key]['image'] = base64_encode($post['image']);
        }
    }

    echo json_encode($posts);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
