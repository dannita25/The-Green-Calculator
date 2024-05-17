<?php
$page_title = 'Green Points';
session_start();
require('connect_db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;  
}

// Fetch green vouchers from the database
function getGreenVouchers($link) {
    $vouchers = array();
    $query = "SELECT * FROM green_vouchers";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $vouchers[] = $row;
    }
    return $vouchers;
}
$vouchers = getGreenVouchers($link);

include('navigation_map.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <h1>Green Points</h1>
    <p>Select from the following green vouchers to contribute to sustainability efforts:</p>
    <div class="row">
        <?php foreach ($vouchers as $voucher): ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($voucher['voucher_type']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($voucher['description']) ?></p>
                        <p class="card-text">Impact: <?= htmlspecialchars($voucher['impact']) ?></p>
                        <p class="card-text">Price: £<?= htmlspecialchars($voucher['price']) ?></p>
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="voucher_id" value="<?= $voucher['voucher_id'] ?>">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
