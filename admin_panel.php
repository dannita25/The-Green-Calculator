<?php
require('connect_db.php'); // Include your database connection
session_start();
$page_title = 'Admin Panel';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Fetch users and their associated company data
$query = "SELECT users.*, companies.company_name, companies.industry, companies.telephone_number, 
        companies.contact_person, companies.status FROM users
        LEFT JOIN companies ON users.user_id = companies.user_id";
$result = mysqli_query($link, $query);

include('admin_header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">

    <title>Admin Panel</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>This is the admin panel. Only authorized users can see this page.</p>
    <table class="admin-table">
        <tr>
            <th>User ID</th><th>First Name</th><th>Last Name</th> 
            <th>Email</th><th>Company Name</th><th>Industry</th>
            <th>Telephone Number</th><th>Contact Person</th>
            <th>Status</th><th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['company_name'] ?? 'N/A'; ?></td>
            <td><?php echo $row['industry'] ?? 'N/A'; ?></td>
            <td><?php echo $row['telephone_number'] ?? 'N/A'; ?></td>
            <td><?php echo $row['contact_person'] ?? 'N/A'; ?></td>
            <td><?php echo $row['status'] ?? 'N/A'; ?></td>
            <td>
                <a href="admin_edit_user.php?user_id=<?php echo $row['user_id']; ?>">Edit Details</a> |
                <a href="admin_edit_company.php?user_id=<?php echo $row['user_id']; ?>">Edit Company Details</a> |
                <a href="admin_delete.php?user_id=<?php echo $row['user_id']; ?>">Delete User</a> |
                <a href="admin_block.php?user_id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to <?php echo $row['status'] === 'deactivated' ? 'unblock' : 'block'; ?> this user?');">
                <?php echo $row['status'] === 'deactivated' ? 'Unblock User' : 'Block User'; ?>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="admin_logout.php">Logout</a>
</body>
</html>
