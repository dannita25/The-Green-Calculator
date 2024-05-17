<?php 
$page_title = 'User Profile';
session_start();
require('connect_db.php'); 
include('header.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Or redirect to index page
    exit;
}

if (isset($_SESSION['password_reset']) && $_SESSION['password_reset']) {
    echo '<script>alert("Your password is temporary. Please update it for your account security.");</script>';
    // Additional UI for updating the password could be placed here
}


$user_id = $_SESSION['user_id'];

// Retrieve user details from 'users' database table
$query = "SELECT u.*, c.company_id, c.company_name, c.industry, c.telephone_number, c.contact_person, c.status, 
        u.first_name, u.last_name, u.email, u.card_number, u.exp_month, u.exp_year, u.temp_pass, u.cvv
        FROM users u 
        LEFT JOIN companies c ON u.user_id = c.user_id 
        WHERE u.user_id = ?";

$stmt = mysqli_prepare($link, $query);
if (!$stmt) {
    echo "Error preparing statement: " . mysqli_error($link);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $user_id);
if (!mysqli_stmt_execute($stmt)) {
    echo "Error executing statement: " . mysqli_error($link);
    exit;
}

$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    echo "Error fetching result: " . mysqli_error($link);
    exit;
}


$row = mysqli_fetch_assoc($result);
if (!$row) {
    echo "<p>No user details found. Please check your database and query.</p>";
    exit;
} else {
    $user_name = ($row['first_name'] ?? 'N/A') . ' ' . ($row['last_name'] ?? 'N/A');
    $email = $row['email'];
    $reg_date = new DateTime($row["reg_date"]);
    $reg_date_formatted = $reg_date ? $reg_date->format('d/m/Y') : 'Not Available';


    // Safely prepare card details for display
    $cardHolder = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
    $cardNumber = isset($row['card_number']) ? '**** **** **** ' . substr(htmlspecialchars($row['card_number']), -4) : 'Not Available';
    $expireDate = isset($row['exp_month'], $row['exp_year']) ? htmlspecialchars($row['exp_month']) . '/' . htmlspecialchars($row['exp_year']) : 'Not Available';
    

    // Check and display user company details
    $companyName = !empty($row['company_name']) ? htmlspecialchars($row['company_name']) : 'N/A';
    $industry = !empty($row['industry']) ? htmlspecialchars($row['industry']) : 'N/A';
    $telephoneNumber = !empty($row['telephone_number']) ? htmlspecialchars($row['telephone_number']) : 'N/A';
    $contactPerson = !empty($row['contact_person']) ? htmlspecialchars($row['contact_person']) : 'N/A';
    $status = !empty($row['status']) ? htmlspecialchars($row['status']) : 'N/A';
    
    // Display user ID email and cvv and temp_pass similarly if needed
    $userId = !empty($row['user_id']) ? htmlspecialchars($row['user_id']) : 'N/A';
    $email = !empty($row['email']) ? htmlspecialchars($row['email']) : 'N/A';
    $cvv = isset($row['cvv']) ? htmlspecialchars($row['cvv']) : 'N/A';
    $temp_pass = isset($row['temp_pass']) ? htmlspecialchars($row['temp_pass']) : 'N/A';
    $companyId = !empty($row['company_id']) ? htmlspecialchars($row['company_id']) : 'N/A';

}

mysqli_close($link);

include('navigation_map.php');
?>
<!doctype html>
<html lang="en">
    <body>
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <div class="alert alert-dark" role="alert">
                        <?php if (isset($_SESSION['update_password'])): ?>
                            <div class="alert alert-warning">
                                <p>Your password has been reset recently. Please <a href="update_tools.php">update your password</a> to ensure your account's security.</p>
                            </div>
                            <?php unset($_SESSION['update_password']); // Remove the flag after showing the message ?>
                        <?php endif; ?>
                    <h2>User Details</h2>
                    <p>Name: <?= $user_name ?></p>
                    <p>Email: <?= $email ?></p>
                    <p>Registration Date: <?= isset($reg_date) ? $reg_date->format('d/m/Y') : 'N/A' ?></p>
                    <button type="button" class="btn btn-secondary btn-block" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                        Update Password
                    </button>
                </div>
            </div>


            <div class="col-md-6">
                <div class="alert alert-dark" role="alert">
                    <h2>Company Details</h2>
                    <!--<p>Company ID: <?= $companyId ?></p>-->
                    <p>Name: <?= $companyName ?></p>
                    <p>Industry: <?= $industry ?></p>
                    <p>Telephone: <?= $telephoneNumber ?></p>
                    <p>Contact Person: <?= $contactPerson ?></p>
                    <p>Status: <?= $status ?></p>
                    <button type="button" class="btn btn-secondary btn-block" data-bs-toggle="modal" data-bs-target="#updateCompanyModal">
                        Update Details
                    </button>
                </div>
            </div>


            <div class="col-md-12">
                <div class="alert alert-dark" role="alert">
                    <h2>Card Stored</h2>
                    <p>Card Holder: <?= $cardHolder ?></p>
                    <p>Card Number: <?= $cardNumber ?></p>
                    <p>Expire Date: <?= $expireDate ?></p>
                    <!--<p>CVV: <?= $cvv ?></p>-->
                    <button type="button" class="btn btn-secondary btn-block" data-bs-toggle="modal" data-bs-target="#updateCardModal">
                        Update Card
                    </button>
                </div>
            </div>
        </div>
    </div>
<!------------------------------------ MODALS FOR UPDATING USER DETAILS ---------------------------------------------->
    <!-- Update PASSWORD Modal -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="update_tools.php" method="POST" onsubmit="return validatePasswordForm()">
                    <input type="hidden" name="updateType" value="password">
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input type="password" class="form-control" id="new-password" name="newPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- COMPANY MODAL: this one pops up when the company details are updated  -->
    <div class="modal fade" id="updateCompanyModal" tabindex="-1" role="dialog" aria-labelledby="updateCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="updateCompanyModalLabel">Update Company Details</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="update_tools.php" method="POST"  onsubmit="return validateCompanyForm()">
            <input type="hidden" name="updateType" value="company_id">
                    <div class="form-group">
                        <label for="companyName">Company Name:</label>
                        <input type="text" class="form-control" id="companyName" name="companyName" required>
                    </div>
                    <div class="form-group">
                        <label for="industry">Industry:</label>
                        <input type="text" class="form-control" id="industry" name="industry" required>
                    </div>
                    <div class="form-group">
                        <label for="telephoneNumber">Telephone Number:</label>
                        <input type="text" class="form-control" id="telephoneNumber" name="telephoneNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="contactPerson">Contact Person:</label>
                        <input type="text" class="form-control" id="contactPerson" name="contactPerson" required>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Update CARD Modal -->
    <div class="modal fade" id="updateCardModal" tabindex="-1" role="dialog" aria-labelledby="updateCardModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCardModalLabel">Update Card Information</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="update_tools.php" method="POST" onsubmit="return validateCardForm()">
                        <input type="hidden" name="updateType" value="card">
                        <div class="form-group">
                            <label for="card-number">Card Number</label>
                            <input type="text" class="form-control" id="card-number" name="cardNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="expiry-date">Expiry Date</label>
                            <input type="month" class="form-control" id="expiry-date" name="expiryDate" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Card</button>
                    </form>
                </div>
            </div>
        </div>   
    </div>   
<!--------------------------- SCRIPTS FOR VALIDATING THE FORMS-------------------------------------------------->        
        <script>

            function validatePasswordForm() {
                var newPassword = document.getElementById("new-password").value;
                
                // Example validation rules: at least 8 characters, must include numbers and letters
                if (!newPassword) {
                    alert("Please enter a password.");
                    return false;
                }
                
                return true; // Allow form submission if validation passes
            }

            function validateCompanyForm() {
                var company_id = document.getElementById("company_id").value;
                var companyName = document.getElementById("companyName").value;
                var industry = document.getElementById("industry").value;
                var telephoneNumber = document.getElementById("telephoneNumber").value;
                var contactPerson = document.getElementById("contactPerson").value;

                 if ( !companyName || !industry || !telephoneNumber || !contactPerson) {
                     alert("All fields must be filled out");
                     return false;
                 }

                return true; // return false to prevent form submission

            }

            function validateCardForm() {
                var cardNumber = document.getElementById("card-number").value;
                var expiryDate = document.getElementById("expiry-date").value;
                var cvv = document.getElementById("cvv").value;

                // Validate card number (basic check for length and all numeric)
                if (!cardNumber || cardNumber.length < 13 || cardNumber.length > 19 || !cardNumber.match(/^[0-9]+$/)) {
                    alert("Please enter a valid card number (should be between 13 and 19 digits).");
                    return false;
                }

                //Validate expiry date (basic check to ensure it's in the future)
                var today = new Date();
                var month = today.getMonth() + 1; // getMonth() is zero-based
                var year = today.getFullYear();
                var [expYear, expMonth] = expiryDate.split('-').map(function(item) { return parseInt(item, 10); });

                if (expYear < year || (expYear === year && expMonth < month)) {
                    alert("The expiry date must be in the future.");
                    return false;
                }

                // Validate CVV (basic check for length and all numeric)
                if (!cvv || cvv.length < 3 || cvv.length > 4 || !cvv.match(/^[0-9]+$/)) {
                    alert("Please enter a valid CVV (should be 3 or 4 digits).");
                    return false;
                }
                return true;
            }
        </script>
        <?php include('footer.php');?>
    </body>
</html>




