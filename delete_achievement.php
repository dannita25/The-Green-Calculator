<?php
session_start();
require('connect_db.php');

if (isset($_GET['id']) && isset($_SESSION['company_id'])) {
    $achievementId = (int)$_GET['id'];
    $query = "DELETE FROM company_achievements WHERE achievement_id = ? AND company_id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $achievementId, $_SESSION['company_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header('Location: dashboard.php'); // Redirect back to the dashboard
exit;
?>
