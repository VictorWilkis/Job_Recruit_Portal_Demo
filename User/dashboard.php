<?php
    require_once 'Assets/controls/dashboard_control.php';
    require 'Assets/controls/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruit Portal | User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidenav.php' ?>

    <!-- Main Content -->
    <div class="main-content ml-5">
        <h2 class="fw-bold">Welcome, <?= $_SESSION['user_username'] ?></h2>

        <?php include 'Assets/includes/recommended_jobs.php'; ?>

        <?php include 'Assets/includes/applied_jobs.php'; ?>
        <!-- <div class="container mt-4 ml-5">
        </div> -->
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
