<?php
session_start(); // Start a new session
$page_title = 'Admin Login'; // Set the page title
require('connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    $query = "SELECT * FROM admin_users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Invalid username or password!";
    }
}
include('admin_header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <form action="admin_login.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>