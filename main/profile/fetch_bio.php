<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=db_55015176', '55015176', '55015176');

if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT bio FROM profile WHERE userprofile = ?");
    $stmt->execute([$_SESSION['username']]);
    $bio = $stmt->fetchColumn();

    
    echo $bio ?: "No bio available.";

} else {
    echo "Not logged in.";
    
    echo "<script>setTimeout(() => window.location.href = 'login.html', 3000);</script>";
}
?>
