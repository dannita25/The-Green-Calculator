<?php
$page_title = 'Edit Company';
session_start();
require('connect_db.php');

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    // Fetch company data
    $query = "SELECT * FROM companies WHERE user_id = $user_id";
    $result = mysqli_query($link, $query);
    $company = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Update company details
        $company_name = mysqli_real_escape_string($link, $_POST['company_name']);
        $industry = mysqli_real_escape_string($link, $_POST['industry']);
        $telephone_number = mysqli_real_escape_string($link, $_POST['telephone_number']);
        $contact_person = mysqli_real_escape_string($link, $_POST['contact_person']);
        $status = mysqli_real_escape_string($link, $_POST['status']);
        
        $update_query = "UPDATE companies 
        SET company_name = '$company_name', industry = '$industry', 
        telephone_number = '$telephone_number', contact_person = '$contact_person', status = '$status' 
        WHERE user_id = $user_id";
        if (mysqli_query($link, $update_query)) {
            header("Location: admin_panel.php");
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($link);
        }
    }
    include('admin_header.php');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Edit Company</title>
    </head>
    <body>
        <h1>Edit Company</h1>
        <form action="" method="post">
            Company Name: <input type="text" name="company_name" value="<?php echo $company['company_name']; ?>"><br>
            Industry: <input type="text" name="industry" value="<?php echo $company['industry']; ?>"><br>
            Telephone Number: <input type="text" name="telephone_number" value="<?php echo $company['telephone_number']; ?>"><br>
            Contact Person: <input type="text" name="contact_person" value="<?php echo $company['contact_person']; ?>"><br>
            Status: <select name="status">
                        <option value="active" <?php echo $company['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $company['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="deactivated" <?php echo $company['status'] == 'deactivated' ? 'selected' : ''; ?>>Deactivated</option>
                    </select><br>
            <input type="submit" value="Update">
        </form>
    </body>
    </html>
    <?php
} else {
    echo "No user specified!";
}
?>
