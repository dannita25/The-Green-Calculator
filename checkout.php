<?php
$page_title = 'Checkout';
session_start();
require('connect_db.php'); // Ensure you have a proper database connection setup
include('header.php'); // Include your header file

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;
}

// Handling cart updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    foreach ($_POST['quantities'] as $id => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $quantity;
        }
    }
    header("Location: checkout.php");
    exit();
}

// Fetching cart items details
if (!empty($_SESSION['cart'])) {
    $itemIds = implode(",", array_keys($_SESSION['cart']));
    $query = "SELECT * FROM green_vouchers WHERE voucher_id IN ($itemIds)";
    $result = mysqli_query($link, $query);
    $vouchers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $vouchers[$row['voucher_id']] = $row;
    }
} else {
    echo "<h5>Your cart is empty. <a href='green_points.php'>Go back to shopping.</a></h5>";
    exit;
}

include('navigation_map.php');

?>
<!DOCTYPE html>
<html lang="en">
<h1>Checkout Page</h1>
<body>
<form action="checkout.php" method="post">
    <table class="table">
        <tr>
            <th>Voucher Type</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
            <tr>
                <td><?= htmlspecialchars($vouchers[$id]['voucher_type']); ?></td>
                <td>£<?= number_format($vouchers[$id]['price'], 2); ?></td>
                <td>
                    <input type="number" name="quantities[<?= $id ?>]" value="<?= $quantity ?>" min="0" class="form-control">
                </td>
                <td>£<?= number_format($quantity * $vouchers[$id]['price'], 2); ?></td>
                <td>
                    <button type="submit" name="update" class="btn btn-info">Update</button>
                </td>
            </tr>
            <?php $total += $quantity * $vouchers[$id]['price']; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Total</td>
            <td>£<?= number_format($total, 2); ?></td>
            <td></td>
        </tr>
    </table>
</form>
<a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">Proceed to Payment</a>
<!-- Custom Confirm Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirm Payment</h5>
                </div>
                <div class="modal-body">
                    The total price of £<?= number_format($total, 2); ?> will be charged to the card registered in your account. Confirm?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.href='user.php';">Update Card</button>
                    <button type="button" class="btn btn-success" onclick="window.location.href='finalize_payment.php';">OK</button>
                </div>
            </div>
        </div>
</div>

<?php include('footer.php'); // Include your footer file ?>
</body>
</html>