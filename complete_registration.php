<?php
$page_title = 'Register Company';
session_start();
require('connect_db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    include('footer.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input here
    $company_name = mysqli_real_escape_string($link, trim($_POST['company_name']));
    $industry = mysqli_real_escape_string($link, trim($_POST['industry']));
    $telephone_number = mysqli_real_escape_string($link, trim($_POST['telephone_number']));
    $contact_person = mysqli_real_escape_string($link, trim($_POST['contact_person']));
    $status = 'active'; // Default to 'active' or based on business logic
    $user_id = $_SESSION['user_id']; // From session

    // Prepare SQL query
    $query = "INSERT INTO companies (company_name, industry, telephone_number, contact_person, status, user_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $company_name, $industry, $telephone_number, $contact_person, $status, $user_id);
    mysqli_stmt_execute($stmt);

    // Check for successful insertion
    if (mysqli_stmt_affected_rows($stmt) == 1) {
        echo "<p>Company details added successfully.</p>";
        // Redirect to profile or another appropriate page
        header("Location: home.php");
        exit();
    } else {
        echo "<p>Error adding company details: " . mysqli_error($link) . "</p>";
    }

    mysqli_stmt_close($stmt);
}
include('header.php');  // Assuming the header includes HTML <head> etc.
?>

<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <h2>Complete Your Registration</h2>
    <form action="complete_registration.php" method="post">
        <div class="form-group">
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="industry">Industry:</label>
            <input type="text" id="industry" name="industry" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telephone_number">Telephone Number:</label>
            <input type="text" id="telephone_number" name="telephone_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact_person">Contact Person:</label>
            <input type="text" id="contact_person" name="contact_person" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Complete Registration</button>
    </form>
</div>
</body>
</html>
