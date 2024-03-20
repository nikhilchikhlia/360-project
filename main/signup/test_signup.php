<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup PHP Page</title>
    </head>

    <body>
        <?php



            $firstName = $_REQUEST['firstName'];
            $lastName = $_REQUEST['lastName'];
            $email = $_REQUEST['email'];
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $confirmedPassword = $_REQUEST['confirmedPass'];
                try {
                    $connString = "mysql:host=localhost;dbname=db_55015176";
                    $user = "55015176";
                    $connPassword = "55015176";
    
                    $pdo = new PDO($connString, $user, $connPassword);
    
                    $sql = "INSERT INTO test_table (username, first_name, last_name, email, password) VALUES ('$username', '$firstName', '$lastName', '$email', '$password')";
                    $count = $pdo->exec($sql);
    
                    echo $count;
                    $pdo = null;
                } catch (PDOException $e) {
                    die( $e->getMessage() );
                }
            
        ?>
    </body>
</html>