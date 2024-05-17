<?php
$page_title = 'Login | GreenCalculator';
session_start();

//  function that checks whether the user has an associated company in the companies table
function hasCompletedRegistration($user_id, $link) {
    $query = "SELECT company_id FROM companies WHERE user_id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $company_id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $company_id; // Return the company ID if user has completed the registration
    } else {
        mysqli_stmt_close($stmt);
        return false; // User has not completed the registration
    }
}

# Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Include database connection and tools
    require('connect_db.php');
    require('login_tools.php');

    // Attempt to validate the login credentials
    list($check, $data) = validate($link, $_POST['email'], $_POST['password_hash']);

    // If validation is successful, set session variables and redirect
    if ($check && $data['status'] !== 'deactivated') {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name']; 

        // Check if user has completed their company registration
        $company_id = hasCompletedRegistration($data['user_id'], $link);
        $_SESSION['company_id'] = $company_id ?: null;

        // Check if the password was marked as temporary
        if ($data['temp_pass']) {
            $_SESSION['password_reset'] = true;  // Set a session flag to indicate password needs updating
        }

        if ($company_id !== false) {
            if (isset($_SESSION['password_reset'])) {
                header("Location: user.php");
                exit();
            } else {
                header("Location: home.php");
                exit();
            }
        } else {
            header("Location: complete_registration.php");
            exit();
        }
    } else {
        $errors = $data;
    }
    mysqli_close($link);
}

include('header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>  
    <div class="container mt-5">  
    <h4> Already a Member? </h4>
        <p> Welcome back! Sign in to your account to continue your sustainability journey with us.</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_hash" class="form-label">Password:</label>
                                <input type="password" id="password_hash" name="password_hash" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Login</button>
                            <!-- Error Messages -->
                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-danger mt-3">
                                        <?php foreach ($errors as $error): ?>
                                            <p><?php echo $error; ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>                           
                        </form>
                        <div class="mt-3">
                            <a href="forgot_password.php" class="link-green">Forgot password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

