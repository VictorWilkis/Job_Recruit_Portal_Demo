<?php
    include 'Assets/includes/db_connect.php';

    // Check if job ID is provided
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: manage_jobs.php");
        exit();
    }

    $job_id = intval($_GET['id']);

    // Fetch job details
    $stmt = $conn->prepare("SELECT title, company, location, salary, required_skills, description FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
    $stmt->close();

    if (!$job) {
        header("Location: manage_jobs.php");
        exit();
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = trim($_POST['title']);
        $company = trim($_POST['company']);
        $location = trim($_POST['location']);
        $salary = trim($_POST['salary']);
        $required_skills = trim($_POST['required_skills']);
        $description = trim($_POST['description']);

        // Prepare update query
        $stmt = $conn->prepare("UPDATE jobs SET title = ?, company = ?, location = ?, salary = ?, required_skills = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $title, $company, $location, $salary, $required_skills, $description, $job_id);

        if ($stmt->execute()) {
            echo "<script>alert('Job updated successfully!'); window.location.href = 'manage_jobs.php';</script>";
        } else {
            echo "<script>alert('Error updating job. Please try again.');</script>";
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-5">
            <h2 class="text-center">Edit Job</h2>

            <form method="POST" class="p-4 bg-light shadow rounded">
                <div class="mb-3">
                    <label for="title" class="form-label">Job Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($job['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" name="company" id="company" class="form-control" value="<?= htmlspecialchars($job['company']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="<?= htmlspecialchars($job['location']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="salary" class="form-label">Salary ($)</label>
                    <input type="number" name="salary" id="salary" class="form-control" value="<?= htmlspecialchars($job['salary']); ?>" min="0">
                </div>

                <div class="mb-3">
                    <label for="required_skills" class="form-label">Required Skills</label>
                    <input type="text" name="required_skills" id="required_skills" class="form-control" value="<?= htmlspecialchars($job['required_skills']); ?>" required>
                    <small class="text-muted">Enter skills separated by commas (e.g., PHP, JavaScript, SQL).</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Job Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" required><?= htmlspecialchars($job['description']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Job</button>
                <a href="manage_jobs.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
