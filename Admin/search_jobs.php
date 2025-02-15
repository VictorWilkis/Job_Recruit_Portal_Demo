<?php
    include 'Assets/includes/db_connect.php';

    // Check if admin is logged in
    require_once 'Assets/controls/dashboard-control.php';

    $search_query = isset($_GET['q']) ? trim($_GET['q']) : "";

    $sql = "SELECT * FROM jobs WHERE 
            title LIKE ? OR 
            company LIKE ? OR 
            location LIKE ? OR 
            required_skills LIKE ?";

    $stmt = $conn->prepare($sql);
    $param = "%$search_query%";
    $stmt->bind_param("ssss", $param, $param, $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Job Search</title>
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#search").on("keyup", function () {
                let query = $(this).val();
                $.get("search_jobs.php?q=" + query, function (data) {
                    $("#job-results").html($(data).find("#job-results").html());
                });
            });
        });

        function deleteJob(jobId) {
            if (confirm("Are you sure you want to delete this job?")) {
                $.post("delete_job.php", { id: jobId }, function(response) {
                    alert(response);
                    location.reload();
                });
            }
        }
    </script>
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <div id="job-results" class="mt-3">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text"><strong>Company:</strong> <?= htmlspecialchars($row['company']) ?></p>
                            <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                            <p class="card-text"><strong>Salary:</strong> $<?= htmlspecialchars($row['salary']) ?></p>
                            <p class="card-text"><strong>Required Skills:</strong> <?= htmlspecialchars($row['required_skills']) ?></p>
                            <a href="edit_job.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                            <button onclick="deleteJob(<?= $row['id'] ?>)" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-warning">No jobs found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
