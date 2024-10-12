<?php
session_start();
include '../partials/header.php';
?>

<h2>Login</h2>
<form action="../controllers/auth.php?action=login" method="POST">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php include '../partials/footer.php'; ?>
