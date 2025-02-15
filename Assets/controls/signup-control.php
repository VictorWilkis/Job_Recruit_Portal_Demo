<?php
    // Database Connection
    require 'db_connect.php';

    $message = ""; // Variable to store status messages

    if (isset($_POST['signup'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $username = trim($_POST['name']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $skills = trim($_POST['skills']); // User skills (comma-separated)
        
            if (empty($email) || empty($username) || empty($password) || empty($confirm_password) || empty($skills)) {
                $message = "<div class='alert alert-danger'>All fields are required!</div>";
            } elseif ($password !== $confirm_password) {
                $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
            } else {
                // Check if email or username already exists
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? ");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
        
                if ($stmt->num_rows > 0) {
                    $message = "<div class='alert alert-danger'>Email already exists!</div>";
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
                    // Insert user into `users` table
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password, skills) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $username, $email, $hashed_password, $skills);
        
                    if ($stmt->execute()) {
                        // Set session and redirect to user dashboard
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_username'] = $username;
        
                        header("Location: User/index.php");
                        exit();
                    } else {
                        $message = "<div class='alert alert-danger'>Something went wrong. Please try again!</div>";
                    }
                }
                $stmt->close();
            }
        }
    }
?>