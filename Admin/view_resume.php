<?php
    session_start();
    require 'Assets/includes/db_connect.php';

    // Ensure admin is logged in
    if (!isset($_SESSION['admin_id'])) {
        die("Access denied.");
    }

    // Validate and get file path
    if (!isset($_GET['file'])) {
        die("Invalid request.");
    }

    $resume_file = urldecode($_GET['file']);
    $resume_path = "../User/Assets/controls/uploads/resumes/" . basename($resume_file);

    // Security check: Ensure file exists and is in the correct directory
    if (!file_exists($resume_path)) {
        die("Resume not found.");
    }

    // Serve the file for viewing
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=" . basename($resume_path));
    readfile($resume_path);
    exit;
?>