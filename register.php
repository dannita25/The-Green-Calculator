<?php
$page_title = 'Register | Green Calculator';
require('connect_db.php');


function validateUserData($data) {
    $errors = [];

    // Validate card number 
    if (empty($data['card_number']) || !preg_match('/^\d{16}$/', $data['card_number'])) {
        $errors['card_number'] = 'A valid card number is required and must be 16 digits.';
    }

    // Validate expiration month
    if (empty($data['exp_month']) || !preg_match('/^0[1-9]|1[0-2]$/', $data['exp_month'])) {
        $errors['exp_month'] = 'Expiration month must be in MM format (01 to 12).';
    }

    // Validate expiration year
    if (empty($data['exp_year']) || !preg_match('/^\d{4}$/', $data['exp_year'])) {
        $errors['exp_year'] = 'Expiration year must be in YYYY format.';
    }

    // Validate CVV
    if (empty($data['cvv']) || !preg_match('/^\d{3,4}$/', $data['cvv'])) {
        $errors['cvv'] = 'CVV must be a 3 or 4-digit number.';
    }

    return $errors;
}

$registration_successful = false; // Flag to check if registration was successful

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userData = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password_hash' => $_POST['password_hash'] ?? '',
        'pass2' => $_POST['pass2'] ?? '',
        'card_number' => $_POST['card_number'] ?? '',
        'exp_month' => $_POST['exp_month'] ?? '',
        'exp_year' => $_POST['exp_year'] ?? '',
        'cvv' => $_POST['cvv'] ?? ''
    ];

    // Validate user input
    $errors = validateUserData($userData);

    // Check if the passwords match
    if ($_POST['password_hash'] != $_POST['pass2']) {$errors[] = 'Passwords do not match.';}

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $password = password_hash($_POST['password_hash'], PASSWORD_DEFAULT);
        $first_name = mysqli_real_escape_string($link, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($link, $_POST['last_name']);
        $card_number = mysqli_real_escape_string($link, $_POST['card_number']);
        $exp_month = mysqli_real_escape_string($link, $_POST['exp_month']);
        $exp_year = mysqli_real_escape_string($link, $_POST['exp_year']);
        $cvv = mysqli_real_escape_string($link, $_POST['cvv']);

        $query = "SELECT user_id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
            mysqli_stmt_close($stmt);

            $query = "INSERT INTO users (first_name, last_name, email, password_hash, card_number, exp_month, exp_year, cvv, reg_date) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, 'ssssssii', $first_name, $last_name, $email, $password, $card_number, $exp_month, $exp_year, $cvv);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) == 1) {$registration_successful = true; // Set the flag to true if registration is successful
            } else {$errors[] = "Error adding the user.";}
        } else {$errors[] = 'Email address already registered. <a href="login.php">Sign In Now</a>';}
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    
}
include('header.php');
// Handle errors, e.g., by displaying them to the user
if (!empty($errors)) {
    foreach ($errors as $key => $error) {
        echo "<p>Error in {$key}: {$error}</p>";
    }
}
?>
<!doctype html>
<html lang="en">
<body>
<div class="container mt-3">
    <?php if ($registration_successful): ?>
        <h4>You are now registered.</h4>
        <p><a href="login.php">Login</a></p>
    <?php else: ?>
    <!--  need to edit this os it looks better -->  
    <h4>New to GreenCalculator?</h4>
    <p>Unlock the full potential of our app by signing up for just £99.99 a year! Take the 
        first step towards earning accreditation for your business today. </p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-header">Create Account</div>
                <div class="card-body">
                    <form action="register.php" class="needs-validation" novalidate method="post">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" required>
                            <div class="invalid-feedback">Please enter your first name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" required>
                            <div class="invalid-feedback">Please enter your last name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <div class="invalid-feedback">Please enter the company email address.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password_hash" class="form-label">Password:</label>
                            <input type="password" id="password_hash" name="password_hash" class="form-control" required>
                            <div class="invalid-feedback">Please enter a password.</div>
                        </div>
                        <div class="mb-3">
                            <label for="pass2" class="form-label">Confirm Password:</label>
                            <input type="password" id="pass2" name="pass2" class="form-control" required>
                            <div class="invalid-feedback">Passwords must match.</div>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-header">Add Payment Card</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Card Number:</label>
                        <input type="text" id="card_number" name="card_number" class="form-control" required>
                        <div class="invalid-feedback">Please enter your card number.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exp_month" class="form-label">Expiration Month (MM):</label>
                        <input type="text" id="exp_month" name="exp_month" class="form-control" required>
                        <div class="invalid-feedback">Please enter the expiration month.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exp_year" class="form-label">Expiration Year (YYYY):</label>
                        <input type="text" id="exp_year" name="exp_year" class="form-control" required>
                        <div class="invalid-feedback">Please enter the expiration year.</div>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV:</label>
                        <input type="text" id="cvv" name="cvv" class="form-control" required>
                        <div class="invalid-feedback">Please enter the CVV.</div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block" id="registerButton">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
function confirmTransaction() {
    if (document.querySelector('form.needs-validation').checkValidity()) {
        var confirmMessage = "We are about to charge your card £99 for registration, would you like to confirm the transaction?";
        if (confirm(confirmMessage)) {
            document.getElementById('registerButton').addEventListener('click', confirmTransaction);
        } else {
            alert('Transaction cancelled');
        }
    } else {
        // Trigger the form's built-in validation
        document.querySelector('form.needs-validation').reportValidity();
    }
}
</script>
<!-- Optional JavaScript; choose Bootstrap Bundle with Popper for better performance -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>
