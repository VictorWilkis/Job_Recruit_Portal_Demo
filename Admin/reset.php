<?php
    require_once 'Assets/controls/reset_control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurit | Admin New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'Assets/includes/navbar.php' ?>
    <div class="cont">
        
    </div>
    <div class="cont1">
        
    </div>
    <div class="login-container mt-5">
        <h3 class="text-center mt-5 mb-5">Admin | Create New Password</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label>New Password:</label>
                <input type="text" name="New Password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password:</label>
                <input type="text" name="Confirm Password" class="form-control" required>
            </div>
            <button name="change" class="btn btn-primary w-100 mt-3">Change</button>
        </form>
    </div>

    <!-- Footer -->
</body>
</html>
