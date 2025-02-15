<?php
    session_start();
    require 'Assets/controls/db_connect.php';

    // Redirect if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $user_skills = "";

    // Fetch the user's skills
    $stmt = $conn->prepare("SELECT skills FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_skills);
    $stmt->fetch();
    $stmt->close();

    $recommended_jobs = [];

    if (!empty($user_skills)) {
        // Convert the user's skills into an array
        $skillsArray = array_map('trim', explode(',', $user_skills));

        // Prepare SQL query to check if all user skills exist in job required skills
        $conditions = [];
        $params = [];
        foreach ($skillsArray as $skill) {
            $conditions[] = "FIND_IN_SET(?, jobs.required_skills) > 0"; // FIND_IN_SET checks if a value exists in a comma-separated string
            $params[] = $skill;
        }

        // Combine conditions using AND (ensuring ALL skills are found in required job skills)
        $query = "SELECT id, title, company, location, description, salary, required_skills FROM jobs WHERE " . implode(" AND ", $conditions);
        $stmt = $conn->prepare($query);

        // Bind parameters dynamically
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);

        // Execute and fetch results
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $recommended_jobs[] = $row;
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruit Portal | Recommended Jobs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body class="bg-light">
    <!-- Navigation Bar -->
    <?php include 'Assets/includes/sidenav.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Recommended Jobs for You</h2>
            <div class="row">
                <?php if (!empty($recommended_jobs)): ?>
                    <?php foreach ($recommended_jobs as $job): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($job['title']); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($job['company']); ?> - <?= htmlspecialchars($job['location']); ?></h6>
                                    <p class="card-text"><?= substr(htmlspecialchars($job['description']), 0, 100); ?>...</p>
                                    <a href="apply.php?job_id=<?= $job['id']; ?>" class="btn btn-success">Apply Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">No recommended jobs available based on your skills.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>