<!DOCTYPE html>
<html>

<?php 
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

} else {
    echo "<p>You need to be logged in to create a post, please login <a href="../login/login.html">here</a> first.</p>"
}
?>

<head>
    <meta charset="utf-8">
    <title>Create a Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="create-post.css">
</head>

<body>
    <a href="../landing/landing.html"><button class="returnBtn">Return Home</button></a>
    <div class="post-container">
        <h2>Create a Post</h2>
        <form method="post">
            <div class="post-input">
                <input type="text" name="post-title" placeholder="Post Title" required>
            </div>
            <div class="post-input">
                <label for="img-upload">Upload an Image:</label>
                <input type="file" id="img-upload" name="img-upload" accept="image/*">
            </div>
            <div class="post-input">
                <input type="textarea" name="description" placeholder="Post Description" required>
            </div>
            <input type="submit" class="submit">
        </form>
    </div>
</body>

</html>