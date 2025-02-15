<?php
    session_start();

    // Check if an admin is not logged in redirect to admin login page
    if (!isset($_SESSION['admin_id'])) {
        header("Location: index.php"); // Redirect admin to admin login page
        exit();
    }

?>
