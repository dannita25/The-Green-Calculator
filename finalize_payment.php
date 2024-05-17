<?php
$page_title = 'Payment';
session_start();
require('connect_db.php');  // Ensure you have a proper database connection setup
$message = "";  // Initialize message variable

// Check if the cart is not empty and user is logged in
if (!empty($_SESSION['cart']) && isset($_SESSION['company_id'])) {
    $companyId = $_SESSION['company_id']; // Assuming the company_id is stored in session

    // Start transaction
    mysqli_begin_transaction($link);

    try {
        foreach ($_SESSION['cart'] as $voucherId => $quantity) {
            // Fetch the price (or points) and calculate the total green points
            $query = "SELECT price, voucher_type, 'voucher' 
            AS achievement_type FROM green_vouchers WHERE voucher_id = ?";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, 'i', $voucherId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $totalGreenPoints = $quantity * $row['price']; // Calculation
                $achievementType = $row['achievement_type'];  
                $achievementDescription = $row['voucher_type'];  

                // Validate achievement_type before insertion
                $validTypes = ['measure', 'voucher'];
                if (!in_array($achievementType, $validTypes)) {
                    throw new Exception("Invalid achievement type specified: $achievementType");
                }

                // Prepare and execute the insertion query into company_achievements
                $insertQuery = "INSERT INTO company_achievements (company_id, achievement_type, achievement_description, points_earned, 
                                date_achieved, voucher_id) VALUES (?, ?, ?, ?, NOW(), ?)";
                $stmt = mysqli_prepare($link, $insertQuery);
                mysqli_stmt_bind_param($stmt, 'issii', $companyId, $achievementType, $achievementDescription, $totalGreenPoints, $voucherId);
                mysqli_stmt_execute($stmt);
            } else {
                // If no price data, throw an error
                throw new Exception("Error fetching price data for voucher ID: $voucherId.");
            }
            mysqli_stmt_close($stmt);
        }

        // Commit the transaction if all insertions are successful
        mysqli_commit($link);
        $_SESSION['cart'] = [];  // Clear the cart after processing the transactions
        $message = "Thank you for your purchase! Your payment has been successfully processed.";
    } catch (Exception $e) {
        mysqli_rollback($link);  // Rollback the transaction on error
        $message = $e->getMessage();  // Set error message
    }
} else {
    $message = "Your cart is empty, or you are not logged in. No transaction was processed.";
}


include('header.php'); // Include your header file
include('navigation_map.php');
?>
<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <h1>Payment Confirmation</h1>
    <p><?= htmlspecialchars($message) ?></p>
    <a href="green_points.php" class="btn btn-success">Continue Shopping</a>
</div>
<?php include('footer.php'); // Include your footer file?>
</body>
</html>



