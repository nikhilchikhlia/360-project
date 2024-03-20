<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup PHP Page</title>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPass'];

        if ($password !== $confirmedPassword) {
            echo "Passwords do not match.";
            exit;
        }

        try {
            $connString = "mysql:host=localhost;dbname=db_55015176";
            $user = "55015176";
            $connPassword = "55015176";
    
            $pdo = new PDO($connString, $user, $connPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $sql = "INSERT INTO test_table (username, first_name, last_name, email, password) 
                    VALUES (:username, :firstName, :lastName, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':email' => $email,
                ':password' => $password
            ]);
    
            echo "User successfully registered.";
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    ?>
</body>
</html>
