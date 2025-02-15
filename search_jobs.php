<?php
    include 'Assets/controls/db_connect.php'; // Include database connection

    if (isset($_GET['query'])) {
        $search = "%" . $_GET['query'] . "%"; // Add wildcards for SQL search

        // Fetch jobs that match the search query
        $stmt = $conn->prepare("SELECT * FROM jobs WHERE title LIKE ? OR company LIKE ? OR location LIKE ? ORDER BY date_posted DESC");
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='job-listing'>";
                echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
                echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company']) . "</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                echo "<p><small>Posted on: " . date('Y-m-d', strtotime($row['date_posted'])) . "</small></p>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<p>No jobs found.</p>";
        }
    }
?>
