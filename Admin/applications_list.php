<?php
    include 'Assets/includes/db_connect.php'; // Include database connection
    include 'Assets/controls/applications_list_control.php'; // control
?>

<div class="container mt-4">
    <h2>Job Applications</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Applicant Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date Applied</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['job_title']) ?></td>
                    <td><?= htmlspecialchars($row['applicant_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><span class="badge bg-<?= ($row['status'] == 'approved') ? 'success' : (($row['status'] == 'rejected') ? 'danger' : 'warning') ?>">
                        <?= ucfirst($row['status']) ?>
                    </span></td>
                    <td><?= date('Y-m-d', strtotime($row['application_date'])) ?></td>
                    <td>
                        <?php if ($row['status'] == 'pending'): ?>
                            <a href="update_application.php?id=<?= $row['id'] ?>&status=approved" class="btn btn-success btn-sm">Approve</a>
                            <a href="update_application.php?id=<?= $row['id'] ?>&status=rejected" class="btn btn-danger btn-sm">Reject</a>
                        <?php else: ?>
                            <span class="text-muted">No Action Required</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
