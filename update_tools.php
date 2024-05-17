<?php
session_start();
require('connect_db.php'); // Make sure your DB connection settings are correct

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    // Optionally redirect to login or throw an error
    exit('Unauthorized access.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['updateType'])) {
        switch ($_POST['updateType']) {
            case 'company_id':
                updateCompanyDetails($link);
                break;
            case 'card':
                updateCardDetails($link);
                break;
            case 'password':
                updatePassword($_SESSION['user_id'], $link);
            
            default:
                exit('No valid update type specified.');
        }
    }
}


//----------------------PASSWORD----------------------------------------
function updatePassword($user_id, $link) {
    $newPassword = $_POST['newPassword'];
    // Hashing the password before storing it
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $query = "UPDATE users SET password_hash=?, temp_pass=0 WHERE user_id=?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            // Optionally, unset the password reset flag
            unset($_SESSION['password_reset']);
            header("Location: user.php?update=success&type=password");
            echo "Execute Error: " . mysqli_stmt_error($stmt);
        } else {
            header("Location: user.php?update=failure&type=password");
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($link);
    }
}


//------------------------COMPANY-----------------------------------------------------------------
function updateCompanyDetails($link) {
    $companyName = $_POST['companyName'];
    $industry = $_POST['industry'];
    $telephoneNumber = $_POST['telephoneNumber'];
    $contactPerson = $_POST['contactPerson'];  // Get the contact person from POST
    $status = $_POST['status'];
    //$companyId = $_POST['company_id']; // assuming you pass the correct company_id from the form

    $query = "UPDATE companies SET company_name=?, industry=?, telephone_number=?, contact_person=?,  
    status=? WHERE company_id=?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $companyName, $industry, $telephoneNumber, $contactPerson, $status, $_SESSION['company_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    //echo("Company details updated successfully"); 
    // Redirect or handle the response as needed
    header("Location: user.php?update=success&type=company_id");
}

//--------------------------------CARD------------------------------------------------------------------
function updateCardDetails($link) {
    //alert ("Password company successfully");
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv']; // Note: Storing CVV is against PCI-DSS compliance

    $expMonth = substr($expiryDate, 5, 2);
    $expYear = substr($expiryDate, 0, 4);

    $query = "UPDATE users SET card_number=?, exp_month=?, exp_year=?, cvv=? WHERE user_id=?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "sssii", $cardNumber, $expMonth, $expYear, $cvv, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Execute Error: " . mysqli_stmt_error($stmt));  // Log the error
            echo "Execute Error: " . mysqli_stmt_error($stmt);       // Display or handle error appropriately
            exit;                                                    // Exit if there is an error
        }
        mysqli_stmt_close($stmt);
    }
    // Redirect or handle the response as needed
    header("Location: user.php?update=success&type=card");
    exit(); 
}

?>

