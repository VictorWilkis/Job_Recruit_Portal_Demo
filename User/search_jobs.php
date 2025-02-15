<?php
    include 'Assets/includes/db_connect.php';

    $search = $_GET['query'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM jobs WHERE title LIKE ? OR company LIKE ? OR location LIKE ?");
    $search_term = "%$search%";
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($job = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $job['title'] ?></td>
            <td><?= $job['company'] ?></td>
            <td><?= $job['location'] ?></td>
            <td>
                <a href="edit_job.php?id=<?= $job['id'] ?>" class="btn btn-warning">Edit</a>
                <a href="delete_job.php?id=<?= $job['id'] ?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
