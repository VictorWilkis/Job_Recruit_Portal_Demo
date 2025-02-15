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
    <div class="main-content bg-white">
        <div class="container mt-4">
            <h2 class="text-center">My Applications</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Status</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $apps = $conn->query("SELECT jobs.title, jobs.company, applications.status FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE applications.user_id = $user_id");
                        while ($row = $apps->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['title'] ?></td>
                                <td><?= $row['company'] ?></td>
                                <td><?= ucfirst($row['status']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
            </table>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
