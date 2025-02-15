<?php
    session_start();
    include 'Assets/includes/db_connect.php';
    $user_id = $_SESSION['user_id'];

    $query = "SELECT jobs.title, applications.status, applications.applied_at, applications.id 
            FROM applications 
            JOIN jobs ON applications.job_id = jobs.id 
            WHERE applications.user_id = ? 
            ORDER BY applications.applied_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($app = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $app['title'] ?></td>
            <td id="status-<?= $app['id'] ?>"><?= ucfirst($app['status']) ?></td>
            <td><?= $app['applied_at'] ?></td>
        </tr>
    <?php endwhile; ?>
    
