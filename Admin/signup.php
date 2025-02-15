<?php
    require_once 'Assets/controls/signup_control.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Admin Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <?= $message; ?>
                        <form action="signup.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Admin Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="Super Admin">Super Admin</option>
                                    <option value="HR Manager">HR Manager</option>
                                    <option value="Recruiter">Recruiter</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Admin Secret Code</label>
                                <input type="password" name="secret_code" class="form-control" required>
                            </div>
                            <button name="register" class="btn btn-primary w-100">Register</button>
                        </form>
                        <p class="text-center mt-3">Already an admin? <a href="index.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
