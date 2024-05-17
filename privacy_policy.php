<?php 
$page_title = 'User Profile';
session_start();
require('connect_db.php');
// Open database connection
include('header.php'); // Include header for consistent layout
include('navigation_map.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
</head>
<body>
<div class="container">
    <h1>Privacy Policy</h1>

    <p><strong>Data Collection:</strong><br>
    We collect detailed information about companies' sustainability practices, including energy consumption, waste management, recycling 
    efforts, and sustainability certifications. This data is gathered directly from companies, public access sources, or through 
    third-party partnerships that focus on environmental impacts.</p>

    <p><strong>Data Usage:</strong><br>
    The collected data is used for the following purposes:</p>
    <ul>
        <li>Providing users with insights into the sustainability practices of various companies.</li>
        <li>Comparing and ranking companies based on their environmental impacts and sustainability efforts.</li>
        <li>Creating reports and content to promote sustainability practices within the industry.</li>
        <li>Improving our website services, such as tailoring content to user interests and optimizing website functionality 
            based on user interaction patterns.</li>
    </ul>

    <p><strong>Data Sharing:</strong><br>
    We may share your data under the following conditions:</p>
    <ul>
        <li>With third-party service providers who assist us in operating our website and conducting business, under strict 
            confidentiality agreements.</li>
        <li>When legally required to comply with the law, enforce our site policies, or protect our or others' rights, property, 
            or safety.</li>
    </ul>

    <p><strong>Regulatory Conditions:</strong><br>
    We require all companies to provide accurate and verifiable information regarding their sustainability practices. This commitment 
    ensures compliance with applicable environmental laws and regulations. We reserve the right to verify the accuracy of the information 
    provided and to take necessary actions in case of any discrepancies or regulatory violations.</p>

    <p><strong>User Rights:</strong><br>
    Users have the right to:</p>
    <ul>
        <li>Request access to personal data we hold about them.</li>
        <li>Ask for corrections to incorrect or incomplete data.</li>
        <li>Request deletion of their personal data from our systems.</li>
        <li>Object to our processing of their personal data.</li>
    </ul>

    <p><strong>Contact Information:</strong><br>
    If you have any questions or concerns about our privacy practices, please contact us at:</p>
    <ul>
        <li>Email: <a href="mailto:info.greencalculator@gmail.com">info.greencalculator@gmail.com</a></li>
        <li>Phone: +44 7999999999</li>
    </ul>
    <?php include('footer.php'); ?>
    </div>
</body>
</html>

