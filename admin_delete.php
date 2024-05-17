<?php
session_start();
require('connect_db.php');

// Check if the user ID is valid and provided
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Delete the user from the database
    $delete_query = "DELETE FROM users WHERE user_id = $user_id";
    if (mysqli_query($link, $delete_query)) {
        echo "User deleted successfully.";
        header("Location: admin_panel.php"); // Redirect back to the admin panel
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($link);
    }
} else {
    echo "Invalid user ID.";
}
?>
