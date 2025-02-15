<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruit Portal | User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- css -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidenav.php' ?>
    <?php include 'Assets/includes/db_connect.php'; ?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <h2>Available Jobs</h2>
            <div class="row">
                <?php
                $jobs = $conn->query("SELECT * FROM jobs");
                while ($job = $jobs->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5><?= $job['title'] ?></h5>
                                <p><strong>Company:</strong> <?= $job['company'] ?></p>
                                <p><strong>Location:</strong> <?= $job['location'] ?></p>
                                <p><strong>Location:</strong> <?= $job['required_skills'] ?></p>
                                <p><strong>Location:</strong> <?= $job['salary'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
