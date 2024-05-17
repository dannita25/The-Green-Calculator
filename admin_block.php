<?php
session_start();
require('connect_db.php');

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    // First, retrieve the current status of the company
    $status_query = "SELECT status FROM companies WHERE user_id = $user_id";
    $status_result = mysqli_query($link, $status_query);
    if ($status_row = mysqli_fetch_assoc($status_result)) {
        $current_status = $status_row['status'];

        // Determine the new status based on the current status
        $new_status = ($current_status === 'deactivated') ? 'active' : 'deactivated';

        // Update the status in the database
        $block_query = "UPDATE companies SET status = '$new_status' WHERE user_id = $user_id";
        if (mysqli_query($link, $block_query)) {
            header("Location: admin_panel.php"); // Redirect back to the admin panel
            exit;
        } else {
            echo "Error updating user status: " . mysqli_error($link);
        }
    } else {
        echo "No company found for this user.";
    }
} else {
    echo "Invalid user ID.";
}
?>

