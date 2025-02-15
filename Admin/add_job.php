<?php 
    include 'Assets/controls/add_jobs_control.php';
    require_once 'Assets/controls/dashboard-control.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurit Admin | Add New Job</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content bg-white">
        <div class="container mt-5">
            <h2>Add a New Job</h2>
            <?= $message; ?>

            <form method="POST" action="add_job.php">
                <div class="mb-3">
                    <label for="title" class="form-label">Job Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Job Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="company" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>

                <div class="mb-3">
                    <label for="salary" class="form-label">Salary (USD)</label>
                    <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
                </div>

                <div class="mb-3">
                    <label for="skills" class="form-label">Required Skills (Comma Separated)</label>
                    <input type="text" class="form-control" id="skills" name="skills" placeholder="Example: PHP, JavaScript, MySQL" required>
                </div>

                <button name="submit" class="btn btn-primary">Add Job</button>
            </form>

        </div>

    </div>

    <!-- Bootstrap & JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
