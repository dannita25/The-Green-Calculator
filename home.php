<?php 
// Define page title before including header to ensure it's dynamically set
$page_title = 'GreenCalculator';

// Include the header section which contains the HTML head
include('header.php');

// Redirect the user to the home page if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); 
    exit;  
}

//Include navigation map
include('navigation_map.php');

// Include main content sections
include('main_content.php');

// Display footer section
include('footer.php');
?>

 