<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
    <!-- Custom CSS for sustainability theme -->
    <style>
        body { background-color: #f4f9f4; }
        .navbar, .footer { background-color: #324851; color: #f4f9f4; }
        .btn-green { background-color: #4caf50; color: white; }
        .card-header { background-color: #8db596; }
        .navbar-brand img { vertical-align: middle; margin-right: 10px; margin-left: 10px; height: 30px; } /* Adjust height as needed */
        .navbar { padding: 0; } 
        .navvbar-brand{ padding: 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-light">
        <a class="navbar-brand text-white" href="admin_panel.php">
        <img src="../img/0.png" alt="Logo">GreenCalculator</a>   
    </nav>

</body>
</html>