<?php
// Start the session and setup the environment
session_start();
$page_title = 'Forgot Password';

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('connect_db.php');
    require('forgot_password_tools.php');

    $email = $_POST['email'] ?? '';
    list($check, $message) = forgot_password($link, $email);

    if ($check) {
        // If password reset was successful, hide form and prepare success message
        $show_form = false;
        $output = "<div class='alert alert-success'>$message</div>
                   <div><a href='login.php' class='btn btn-primary'>Go back to login</a></div>";
    } else {
        // Password reset failed, prepare error message
        $output = "<div class='alert alert-danger'>$message</div>
                   <a href='forgot_password.php' class='btn btn-green'>Try again</a>";
    }
} else {
    $show_form = true;
    $output = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon" href="../img/0.png" type="image/x-icon">    
    <style>
        body { background-color: #f4f9f4; }
        .navbar, .footer { background-color: #324851; color: #f4f9f4; }
        .btn-green { background-color: #4caf50; color: white; }
        .card-header { background-color: #8db596; }
        .navbar-brand img { vertical-align: middle; margin-right: 10px; margin-left: 10px; height: 30px; } 
        .navbar { padding: 0; } 
        .navvbar-brand{ padding: 0; }
    </style>
</head>
<body>
<?php include('header.php'); ?>
    <div class="container mt-5">
        <h2>Forgot Password</h2>
        <?php if ($show_form): ?>
            <p>Please enter your email address below.</p>
            <form action="forgot_password.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Reset Password</button>
            </form>
        <?php else: ?>
            <?php echo $output; ?>
        <?php endif; ?>
    </div>
</body>
</html> 