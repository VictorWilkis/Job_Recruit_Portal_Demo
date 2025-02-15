<?php
    include 'Assets/includes/db_connect.php';
    require_once 'Assets/controls/dashboard-control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurit | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

<!-- Sidebar Navigation -->
<?php include 'Assets/includes/sidebar.php' ?>

<!-- Main Content -->
<div class="main-content bg-white h-100vh">
    <div class="container mt-4">
        <h2>Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5>Total Jobs</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM jobs")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5>Total Applications</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM applications")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5>Approved Applications</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status='Approved'")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5>Rejected Applications</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status='Rejected'")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5>Pending Applications</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status='pending'")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5>Total Users</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5>Total Admins</h5>
                        <h2><?= $conn->query("SELECT COUNT(*) AS total FROM admin")->fetch_assoc()['total'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
