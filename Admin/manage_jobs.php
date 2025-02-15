<?php
    include 'Assets/includes/db_connect.php';
    require_once 'Assets/controls/dashboard-control.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruit Admin | Manage Jobs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="mb-4 text-white">Manage Jobs</h2>

        <!-- Search Input -->
        <input type="text" id="searchJob" class="form-control mb-3" placeholder="Search for jobs...">

        <!-- Job Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Required Skills</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="jobTable">
                <?php
                    $result = $conn->query("SELECT * FROM jobs ORDER BY date_posted DESC");
                    while ($job = $result->fetch_assoc()): 
                ?>
                <tr>
                    <td><?= htmlspecialchars($job['title']); ?></td>
                    <td><?= htmlspecialchars($job['company']); ?></td>
                    <td><?= htmlspecialchars($job['location']); ?></td>
                    <td>$<?= number_format($job['salary'], 2); ?></td>
                    <td><?= htmlspecialchars($job['required_skills']); ?></td>
                    <td>
                        <a href="edit_job.php?id=<?= $job['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_job.php?id=<?= $job['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery & AJAX for Live Search -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#searchJob").on("keyup", function() {
                let query = $(this).val();
                $.ajax({
                    url: "search_jobs.php",
                    method: "GET",
                    data: { query: query },
                    success: function(data) {
                        $("#jobTable").html(data);
                    }
                });
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
