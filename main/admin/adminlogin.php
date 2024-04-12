<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'db_55015176'; 
$dbUsername = '55015176'; 
$dbPassword = '55015176';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Adjust the SQL statement to query your admin users table or column
        $sql = "SELECT * FROM admin WHERE username = :username AND password = :password LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username, ':password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Successful login
            $_SESSION['admin_username'] = $user['username'];
            echo "Admin login successful. Redirecting...";
            header("Location: admindashboard.php");
            exit;
        } else {
            echo "<p>Invalid admin credentials. Please <a href='adminlogin.html'>try again</a>.</p>";
        }
    }
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
