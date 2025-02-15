<?php
    require 'Assets/controls/db_connect.php';

    require_once 'Assets/controls/dashboard_control.php';


    $message = "";

    // Fetch all available jobs
    $sql = "SELECT * FROM jobs ORDER BY date_posted DESC";
    $result = $conn->query($sql);

   // Handle job application submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
        $user_id = $_SESSION['user_id'];
        $job_id = ($_POST['job_id']); // Sanitize job ID
        $cover_letter = ($_POST['cover_letter']);
        $status = 'Pending';

        // Check if user has already applied for this job
        $check_stmt = $conn->prepare("SELECT * FROM applications WHERE user_id = ? AND job_id = ?");
        $check_stmt->bind_param("ii", $user_id, $job_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "<div class='alert alert-warning'>You have already applied for this job.</div>";
        } else {
            // Handle resume upload
            if (!empty($_FILES['resume']['name'])) {
                $target_dir = "Assets/controls/uploads/resumes/";
                $resume_file = $target_dir . basename($_FILES['resume']['name']);
                $resumeFileType = strtolower(pathinfo($resume_file, PATHINFO_EXTENSION));
                
                // Validate file type
                $allowed_types = ['pdf', 'doc', 'docx'];
                if (!in_array($resumeFileType, $allowed_types)) {
                    $message = "<div class='alert alert-danger'>Only PDF, DOC, and DOCX files are allowed.</div>";
                } elseif ($_FILES['resume']['size'] > 5000000) { // Limit file size (5MB)
                    $message = "<div class='alert alert-danger'>File size exceeds 5MB limit.</div>";
                } elseif (move_uploaded_file($_FILES['resume']['tmp_name'], $resume_file)) {
                    // Insert application into database
                    $apply_stmt = $conn->prepare("INSERT INTO applications (user_id, job_id, resume, cover_letter, status) VALUES (?, ?, ?, ?, ?)");
                    $apply_stmt->bind_param("iisss", $user_id, $job_id, $resume_file, $cover_letter, $status);

                    if ($apply_stmt->execute()) {
                        $message = "<div class='alert alert-success'>Application submitted successfully!</div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Error submitting application.</div>";
                    }
                    $apply_stmt->close();
                } else {
                    $message = "<div class='alert alert-danger'>Error uploading resume.</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Please upload your resume.</div>";
            }
        }
        $check_stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?= htmlspecialchars($job['title'] ?? 'Job') ?></title>
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <?php include 'Assets/includes/sidenav.php' ?>
    <!-- Main Content -->
    <div class="main-content ml-5">
        <h2 class="text-center mt-5 mb-4">Available Jobs</h2>
        <?= $message; ?>
    
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Salary (USD)</th>
                    <th>Required Skills</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $count = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= htmlspecialchars($row['company']); ?></td>
                            <td><?= htmlspecialchars($row['location']); ?></td>
                            <td>$<?= htmlspecialchars($row['salary']); ?></td>
                            <td><?= htmlspecialchars($row['required_skills']); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#applyModal<?= $row['id']; ?>">Apply</button>

                                <!-- Apply Modal -->
                                <div class="modal fade" id="applyModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Apply for <?= htmlspecialchars($row['title']); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="job_id" value="<?= $row['id']; ?>">

                                                    <div class="mb-3">
                                                        <label for="resume" class="form-label">Upload Resume (PDF/DOC/DOCX)</label>
                                                        <input type="file" class="form-control" name="resume" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="cover_letter" class="form-label">Cover Letter</label>
                                                        <textarea class="form-control" name="cover_letter" rows="3" required></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-success">Submit Application</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No jobs available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
