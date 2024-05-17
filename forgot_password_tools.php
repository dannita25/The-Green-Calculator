<?php
function forgot_password($link, $email) {
    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        // Generate a new random password
        $new_password = generateRandomPassword();

        // Update the user's password in the database
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET password_hash = ?, temp_pass = 1 WHERE email = ?";
        $update_stmt = mysqli_prepare($link, $update_query);
        mysqli_stmt_bind_param($update_stmt, 'ss', $password_hash, $email);
        mysqli_stmt_execute($update_stmt);

        if (mysqli_stmt_affected_rows($update_stmt) == 1) {
            // PRINT THE NEW PASSWORD
            $message = "Your new password is: " . $new_password;

            return [true, $message];
        } else {
            // Password reset failed
            $message = "Password reset failed. Please try again later.";
            return [false, $message];
        }
    } else {
        // Email address not found
        $message = "Email address not found.";
        return [false, $message];
    }
}

// Function to generate a random password
function generateRandomPassword($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}
?>

