<?php 
$page_title = 'Contact Us';
require('connect_db.php');

include('header.php');
include('navigation_map.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;  
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the form
    $user_id = $_SESSION['user_id'];  // Assuming user is logged in and user_id is stored in session
    $name = mysqli_real_escape_string($link, trim($_POST['name']));
    $email = mysqli_real_escape_string($link, trim($_POST['email']));
    $contact_number = mysqli_real_escape_string($link, trim($_POST['contact_number']));
    $subject = mysqli_real_escape_string($link, trim($_POST['subject']));
    $message = mysqli_real_escape_string($link, trim($_POST['message']));
    $date_received = date('Y-m-d H:i:s');  // Current date and time

    // Insert the new inquiry into the database
    $query = "INSERT INTO contact_us (user_id, name, email, contact_number, subject, message, date_received, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'issssss', $user_id, $name, $email, $contact_number, $subject, $message, $date_received);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) == 1) {
        echo '<p>Your message has been sent.</p>';
    } else {
        echo '<p>Error when sending your message, try again later please.</p>';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
<div class="container">
    <div class="row">
        <!-- Column for the contact form -->
        <div class="col-md-6">
            <h1>Contact Us</h1>
            <p>Please fill out this form to contact us and we will get back to you as soon as possible!</p>
            <form action="contact_us.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|co\.uk|org)$">
                </div>
                <div class="form-group">
                    <label for="contact_number">Phone Number:</label>
                    <input type="tel" id="contact_number" name="contact_number" class="form-control" required pattern="07[0-9]{9}" title="Enter a valid UK phone number starting with 07">
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Send</button>
            </form>
        </div>
        <!-- Column for the image -->
        <div class="col-md-6">
            <img src="../img/leaves/1.jpg" alt="a sheep baaing " class="img-fluid">
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
