<!-- Update Password Modal Form -->
<form action="update_password.php" method="post">
    <div class="form-group">
        <label for="current-password">Current Password</label>
        <input type="password" class="form-control" id="current-password" name="current_password" required>
    </div>
    <div class="form-group">
        <label for="new-password">New Password</label>
        <input type="password" class="form-control" id="new-password" name="new_password" required>
    </div>
    <button type="submit" class="btn btn-success">Update Password</button>
</form>
