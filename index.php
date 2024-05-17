<?php
$page_title = 'Welcome | GreenCalculator';
// Check if a session is already started; if not, start a session
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$logged_in = isset($_SESSION['user_id']); // Check if user is logged in


include('header.php');
?>
<!doctype html>
<html lang="en">
<body>
<div class="container mt-5"> 
    <h4>Welcome to GreenCalculator! </h4>
    <p>We are thrilled to have you join our community of eco-conscious individuals who are committed to 
        making a positive impact on our planet. </p>

    <p> Unlock the full potential of our app by signing up for just £99 a year! 
        Take the first step towards earning accreditation and certificates for your business today.</p>    
    
        <div class="row justify-content-center">
            <div class="col-sm">
                <div class="card bg-light mb-3">
                    <div class="card-header">Create Account</div>
                    <div class="card-body">                       
                        <p class="card-text">Don't have an account? Create one to start using our app.</p>
                        <a href="register.php" class="btn btn-success btn-lg btn-block">Create Account</a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card bg-light mb-3">
                    <div class="card-header">Account</div>
                    <div class="card-body">
                        <p class="card-text">Already have an account? Sign in now to use our app.</p>
                        <a href="login.php" class="btn btn-success btn-lg btn-block">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript; choose Bootstrap Bundle with Popper for better performance -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>    
</body>
</html>