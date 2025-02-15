<?php
    require_once 'Assets/controls/login-control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurit | Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'Assets/includes/navbar.php' ?>
    <div class="cont">
        
    </div>
    <div class="login-container mt-5">
        <h3 class="text-center mt-5 mb-5">Admin Login</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action = "index.php" method="post">
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button name="login" class="btn btn-primary w-100 mt-3">Login</button>
        </form>
        <p class="text-center mt-3">
            Forgotten Password? <a href="forgot.php">Forgot</a>
        </p>
    </div>

</body>
</html>
