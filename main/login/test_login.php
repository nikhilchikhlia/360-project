<?php
session_start();

$host = 'localhost';
$dbname = 'testing';
$dbUsername = 'root';
$dbPassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username, 
            ':password' => $password
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedin'] = true;
            echo "Login successful. Redirecting...";
            header("Location: ../landing/landing.html");
            exit;
        } else {
            echo "<p>Invalid credentials. Please <a href='login.html'>try again</a>.</p>";
        }
    }
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
