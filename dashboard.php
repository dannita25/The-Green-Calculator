<?php
$page_title = 'Dashboard';
session_start();
require('connect_db.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;  
}

if (!isset($_SESSION['company_id'])) {
    echo "<p>Error: Your session has expired or you are not logged in. Please log in again.</p>";
    exit;
}

$companyId = $_SESSION['company_id'];

function fetchSumPoints($link, $companyId, $type) {
    $query = "SELECT SUM(points_earned) AS totalPoints FROM company_achievements 
            WHERE company_id = ? AND achievement_type = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'is', $companyId, $type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalPoints);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $totalPoints;
}

$totalPointsMeasures = fetchSumPoints($link, $companyId, 'measure');
$totalPointsVouchers = fetchSumPoints($link, $companyId, 'voucher');

$goldThreshold = 100;
$silverThreshold = 75;
$bronzeThreshold = 50;

$certificateType = null;
$totalScore = null;

include('navigation_map.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Company Dashboard</h1>        
            <h4>Points Summary</h4>
        
            <p><strong>Total Points from Measures:</strong> <?= $totalPointsMeasures ?: '0' ?></p>
            <p><strong>Total Points from Vouchers:</strong> <?= $totalPointsVouchers ?: '0' ?></p>
        
            <?php 
            $totalPoints = $totalPointsMeasures + $totalPointsVouchers;
            if ($totalPoints >= 100) {
                echo "<p>You won a golden certificate!</p>"; 
                $_SESSION['certificate_type'] = 'golden';
                echo '<a href="generate_certificate.php" class="btn btn-success">Generate Certificate</a>';

            } elseif ($totalPoints >= 75 && $totalPoints < 100) {
                echo "<p>You won a silver certificate!</p>";
                $_SESSION['certificate_type'] = 'silver';
                echo '<a href="generate_certificate.php" class="btn btn-success">Generate Certificate</a>';

            } elseif ($totalPoints >= 50 && $totalPoints < 75) {
                echo "<p>You won a bronze certificate!</p>";            
                $_SESSION['certificate_type'] = 'bronze';
                echo '<a href="generate_certificate.php" class="btn btn-success">Generate Certificate</a>';
            
            } else {
                echo "<p>No certificate is available yet, but we encourage you to keep up the good work!</p>";
            }
            ?>        
        </div>

        <div class="col-md-6">
            <img src="../img/more/bicis.jpg" alt="a sheep baaing " class="img-fluid" style="max-width: 600px; align-items: center">
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>

