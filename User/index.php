<?php
    require_once 'Assets/controls/login-control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Recruit Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'Assets/includes/navbar.php' ?>

    <div class="cont">
        
    </div>

    <div class="container mt-5 login-container">
        <h2 class="text-center mb-4 mt-5">User Login</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3">
                    Forgotten Password? <a href="forgot.php">Forgot</a> <br><br>
                    Don't have an account? <a href="../signup.php">Sign Up</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'Assets/includes/footer.php' ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
