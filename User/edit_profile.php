<?php
    session_start();
    require 'Assets/controls/db_connect.php';

    // Redirect if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $success_message = $error_message = "";

    // Fetch user details
    $stmt = $conn->prepare("SELECT username, email, skills FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $skills = trim($_POST['skills']); // Skills stored as comma-separated values
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($name) || empty($email)) {
            $error_message = "Name and email are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format.";
        } else {
            if (!empty($password) && !empty($new_password)) {
                // Validate current password
                $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->bind_result($hashed_password);
                $stmt->fetch();
                $stmt->close();

                if (!password_verify($password, $hashed_password)) {
                    $error_message = "Current password is incorrect.";
                } elseif ($new_password !== $confirm_password) {
                    $error_message = "New passwords do not match.";
                } else {
                    // Hash new password
                    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, skills = ?, password = ? WHERE id = ?");
                    $stmt->bind_param("ssssi", $name, $email, $skills, $new_hashed_password, $user_id);
                }
            } else {
                // Update without password change
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, skills = ? WHERE id = ?");
                $stmt->bind_param("sssi", $name, $email, $skills, $user_id);
            }

            if ($stmt->execute()) {
                $success_message = "Profile updated successfully!";
                $stmt->close();
                // Refresh user data
                header("Location: edit_profile.php");
                exit();
            } else {
                $error_message = "Error updating profile.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidenav.php' ?>

    <div class="main-content ml-5">
        <div class="container mt-5">
            <h2>Edit Profile</h2>
    
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
            <?php elseif ($error_message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
    
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Skills (comma-separated)</label>
                    <input type="text" name="skills" class="form-control" value="<?= htmlspecialchars($user['skills']); ?>" placeholder="e.g., PHP, JavaScript, SQL">
                </div>
    
                <hr>
    
                <h4>Change Password (Optional)</h4>
    
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter current password">
                </div>
    
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password">
                </div>
    
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
