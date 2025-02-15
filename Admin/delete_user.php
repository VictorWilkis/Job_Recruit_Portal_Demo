<?php
    session_start();
    require 'Assets/controls/db_connect.php';

    // Check if user ID is provided
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $_SESSION['error'] = "Invalid user ID.";
        header("Location: manage_users.php");
        exit();
    }

    $user_id = intval($_GET['id']); // Ensure it's an integer

    // Verify if the user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['error'] = "User not found.";
        $stmt->close();
        header("Location: manage_users.php");
        exit();
    }
    $stmt->close();

    // Delete user from database
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_stmt->bind_param("i", $user_id);
    if ($delete_stmt->execute()) {
        $_SESSION['success'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete user.";
    }
    $delete_stmt->close();

    // Redirect back to manage users page
    header("Location: manage_users.php");
exit();
?>
