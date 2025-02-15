<?php
    // Database Connection
    require 'db_connect.php';

    $message = ""; // Store messages for feedback
    
    if(isset($_POST['register'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $secret_code = trim($_POST['secret_code']);
            $role = trim($_POST['role']); // Admin Role
        
            // Admin secret key (to restrict admin registration)
            $admin_secret_key = "ADMIN123"; 
        
            // Validate fields
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($secret_code) || empty($role)) {
                $message = "<div class='alert alert-danger'>All fields are required!</div>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "<div class='alert alert-danger'>Invalid email format!</div>";
            } elseif ($password !== $confirm_password) {
                $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
            } elseif (strlen($password) < 6) {
                $message = "<div class='alert alert-danger'>Password must be at least 6 characters!</div>";
            } elseif ($secret_code !== $admin_secret_key) {
                $message = "<div class='alert alert-danger'>Invalid admin secret code!</div>";
            } else {
                // Check if admin email exists
                $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
        
                if ($stmt->num_rows > 0) {
                    $message = "<div class='alert alert-danger'>Admin email already exists!</div>";
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
                    // Insert new admin user with role
                    $stmt = $conn->prepare("INSERT INTO admin (username, email, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        
                    if ($stmt->execute()) {
                        $message = "<div class='alert alert-success'>Admin registered successfully! <a href='index.php'>Login here</a></div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Something went wrong!</div>";
                    }
                }
                $stmt->close();
            }
        }
    }
    
?>