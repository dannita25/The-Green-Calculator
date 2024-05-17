<?php
$page_title = 'Logout | GreenCalculator';
session_start();

// Destroy all session data.
session_destroy();

// Redirect to a logged-out confirmation page.
header('Location: goodbye.php');
exit();
?>

