<?php
    session_start();
    require 'Assets/controls/db_connect.php';

    // Redirect if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch user information
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Fetch user application history (resumes are stored per application)
    $stmt = $conn->prepare("
        SELECT jobs.title, applications.status, applications.application_date AS applied_at, applications.resume 
        FROM applications 
        JOIN jobs ON applications.job_id = jobs.id 
        WHERE applications.user_id = ?
        ORDER BY applications.application_date DESC
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidenav.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <h2>User Profile</h2>

            <!-- User Information -->
            <div class="card p-3 mb-3">
                <h4>Personal Information</h4>
                <p><strong>Name:</strong> <?= htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>

            <!-- Application History -->
            <h4>Application History</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th>Resume</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($applications->num_rows > 0): ?>
                        <?php while ($app = $applications->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($app['title']); ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $app['status'] == 'Pending' ? 'bg-warning' : 
                                        ($app['status'] == 'Approved' ? 'bg-success' : 'bg-danger') ?>">
                                        <?= ucfirst(htmlspecialchars($app['status'])); ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($app['applied_at']); ?></td>
                                <td>
                                    <?php 
                                        if (!empty($app['resume'])):
                                            $resu = urldecode($app['resume']);
                                            
                                    ?>
                                        <a href="<?= "Assets/controls/uploads/resumes/" . basename($resu) ?>" target="_blank">View Resume</a>
                                    <?php else: ?>
                                        <span class="text-muted">No resume uploaded</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No applications found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>