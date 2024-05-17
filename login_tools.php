<?php
# Function to check email address and password using prepared statements.
function validate($link, $email = '', $pwd = '') {
    $errors = []; // Initialize an array to store any validation errors

    # Check if email and password are provided
    if (empty($email) || empty($pwd)) {
        $errors[] = 'Please enter both email and password.';
        return [false, $errors]; // Return validation failure with error message
    }

    # Prepare and execute SQL statement to fetch user data based on email
    $q = "SELECT u.user_id, u.first_name, u.last_name, u.password_hash, u.temp_pass, c.status 
        FROM users u
        LEFT JOIN companies c ON u.user_id = c.user_id
        WHERE u.email = ?";
    $stmt = mysqli_prepare($link, $q);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $first_name, $last_name, $password_hash, $temp_pass, $status);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        # Verify password using password_verify function
        if (password_verify($pwd, $password_hash)) {
            if ($status === 'deactivated') {
                $errors[] = 'Your account has been deactivated. Please contact info@greencalculator.com for assistance.';
                return [false, $errors]; // Return with error if account is deactivated
            }
            return [true, ['user_id' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'temp_pass' => $temp_pass]]; // Return validation success with user data
        } else {
            $errors[] = 'Invalid email or password, try again.';
            return [false, $errors]; // Return validation failure with error message
        }
    } else {
        $errors[] = 'Database error. Please try again later.';
        return [false, $errors]; // Return validation failure with error message
    }
}
?>

