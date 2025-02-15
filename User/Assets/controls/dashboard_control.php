<?php
    session_start();

    // If a user is logged in, redirect to the user dashboard
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php"); // Redirect user to user dashboard
        exit();
    }
?>
