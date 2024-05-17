<!DOCTYPE html>
<html lang="en">
<?php 
$page_title = 'About Us';
session_start();
include('header.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;  
}
include('navigation_map.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About the Green Calculator</title>
</head>
<body>
<div class="content">
    <div class="about-calculator">
        <h1>About the Green Calculator</h1>
        <p>The Green Calculator is designed to empower organizations to measure, understand, and enhance their environmental impact. 
            By providing actionable insights, our tool helps companies transition towards more sustainable practices.</p>
        <p>This tool evaluates your company activities across a range of sustainability metrics, including carbon emissions, 
            energy use, waste management, and more. Here is how you can leverage the Green Calculator to your advantage:</p>
    </div>

    <div class="benefits">
        <h2>Benefits of Using the Green Calculator</h2>
        <p>Using the Green Calculator brings several benefits:</p>
        <ul>
            <li><strong>Educational:</strong> Learn about potential areas of improvement and the impact of different sustainability practices.</li>
            <li><strong>Operational Efficiency:</strong> Identify inefficiencies in your operations and find ways to reduce costs 
            and resource usage.</li>
            <li><strong>Compliance and Reporting:</strong> Use your results to comply with environmental regulations and enhance 
            your reporting for transparency.</li>
        </ul>
    </div>

    <div class="our-mission">
        <h2>Our Mission</h2>
        <p>Our mission is to provide tools and insights that promote environmental stewardship and sustainable growth. 
            The Green Calculator is a step towards helping businesses become proactive in their sustainability journey.</p>
    </div>
</div>

<?php 
    // Display footer section
    include('footer.php');
?>
</body>
</html>
