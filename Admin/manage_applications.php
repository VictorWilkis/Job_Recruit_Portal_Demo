<?php
    session_start();
    include 'Assets/controls/db_connect.php';

    // Check if admin is logged in
    if (!isset($_SESSION['admin_id'])) {
        header("Location: index.php");
        exit();
    }

    // Fetch all job applications with job and user details
    $sql = "SELECT applications.id, applications.status, applications.application_date, 
                    applications.resume, applications.cover_letter, 
                    users.username, users.email, 
                    jobs.title AS job_title, jobs.company 
            FROM applications 
            JOIN users ON applications.user_id = users.id 
            JOIN jobs ON applications.job_id = jobs.id 
            ORDER BY applications.application_date DESC";

    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Applications</title>
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateStatus(appId, newStatus) {
            $.post("update_application_status.php", { id: appId, status: newStatus })
            .done(function(response) {
                try {
                    let res = JSON.parse(response);
                    alert(res.message);
                    if (res.success) location.reload();
                } catch (e) {
                    alert("Error: Invalid response from server.");
                }
            })
            .fail(function() {
                alert("Error: Could not connect to the server.");
            });
        }
    </script>
</head>
<body>
    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content bg-white h-100vh">
        <div class="container mt-5">
            <h2>Manage Job Applications</h2>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Applicant Name</th>
                        <th>Email</th>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $count = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['job_title']); ?></td>
                                <td><?= htmlspecialchars($row['company']); ?></td>
                                <td><?= htmlspecialchars($row['application_date']); ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $row['status'] == 'Pending' ? 'bg-warning' : 
                                        ($row['status'] == 'Approved' ? 'bg-success' : 'bg-danger') ?>">
                                        <?= htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($row['resume'])): ?>
                                        <a href="view_resume.php?file=<?= urlencode($row['resume']); ?>" target="_blank" class="btn btn-info btn-sm">View Resume</a>
                                    <?php else: ?>
                                        <span class="text-muted">No Resume</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'Pending'): ?>
                                        <button onclick="updateStatus(<?= $row['id']; ?>, 'Approved')" class="btn btn-success btn-sm">Approve</button>
                                        <button onclick="updateStatus(<?= $row['id']; ?>, 'Rejected')" class="btn btn-danger btn-sm">Reject</button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <?= ($row['status'] == 'Approved') ? 'Approved' : 'Rejected'; ?>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No applications found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>