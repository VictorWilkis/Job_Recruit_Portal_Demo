<?php
    session_start();
    require 'Assets/controls/db_connect.php';

    // Ensure the user is an admin (add your own authentication check)
    require_once 'Assets/controls/dashboard-control.php';

    // Check if job ID is provided
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $job_id = $_GET['id'];

        // Prepare delete statement
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
        $stmt->bind_param("i", $job_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Job deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete job. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Invalid job ID.";
    }

    // Redirect back to manage jobs page
    header("Location: manage_jobs.php");
    exit();
?>
