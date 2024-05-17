<?php
//session_start();
require('connect_db.php');
require('login_tools.php');

# Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to the login page if not logged in
    exit;
}

# Initialize the cart quantity
$quantity = isset($_SESSION['quantity']) ? $_SESSION['quantity'] : 0;
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) + $quantity : 0;
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     
    <!-- Bootstrap CSS -->   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="https://kit.fontawesome.com/bb3ef965c3.js" crossorigin="anonymous"></script>
    <title>Green Calculator</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="green_calculator.php">Green Calculator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="green_points.php">Green Points</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="certificates.php">Certificates and Partners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sustainability.php">Sustainability</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>
                <!-- User account dropdown -->
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= "{$_SESSION['first_name']} {$_SESSION['last_name']} <i class='fa fa-user'></i>"; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="user.php">Account Settings</a></li>
                        <li><a class="dropdown-item" href="dashboard.php">Your Dashboard</a></li>
                        <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Cart button -->
            <a href="checkout.php" class="btn btn-outline-secondary" role="button">
                <i class="fas fa-shopping-cart"></i>
                Cart <span class="badge bg-secondary"><?= $num_items_in_cart ?></span>
            </a>
        </div>
    </div>
</nav>
</body>
</html>
