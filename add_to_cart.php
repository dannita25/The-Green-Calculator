<?php
$page_title = 'Cart';
session_start();
require('connect_db.php'); // Ensure you have a proper database connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['voucher_id'])) {
    $voucherId = $_POST['voucher_id'];
    $quantity = 1; // Assuming you add one voucher at a time, or adjust based on form input

    // Check if the cart already exists in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update the quantity of the voucher in the cart
    if (isset($_SESSION['cart'][$voucherId])) {
        $_SESSION['cart'][$voucherId] += $quantity;
    } else {
        $_SESSION['cart'][$voucherId] = $quantity;
    }

    // Redirect to green points page
    header("Location: green_points.php");
    exit();
} else {
    // Redirect back to shopping page if accessed incorrectly
    header("Location: checkout.php");
    exit();
}
?>
