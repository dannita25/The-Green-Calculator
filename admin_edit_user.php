<?php
$page_title = 'Edit User details';
session_start();
require('connect_db.php');

// Check if the user ID is valid and provided
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Process the form when it's submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = mysqli_real_escape_string($link, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($link, $_POST['last_name']);
        $email = mysqli_real_escape_string($link, $_POST['email']);

        // Update the user details in the database
        $update_query = "UPDATE users 
        SET first_name = '$first_name', last_name = '$last_name', email = '$email' 
        WHERE user_id = $user_id";
        if (mysqli_query($link, $update_query)) {
            echo "User updated successfully.";
            header("Location: admin_panel.php"); // Redirect to the admin panel
            exit;
        } else {
            echo "Error updating user: " . mysqli_error($link);
        }
    }

    // Fetch the existing user data
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($link, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        include('admin_header.php');
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Edit User</title>
        </head>
        <body>
            <h1>Edit User</h1>
            <form action="" method="post">
                First Name: <input type="text" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>"><br>
                Last Name: <input type="text" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>"><br>
                Email: <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>
                <input type="submit" value="Update User">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid user ID.";
}
?>
