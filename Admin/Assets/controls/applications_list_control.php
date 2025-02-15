<?php
    // Fetch applications from the database
    $sql = "SELECT applications.id, users.name AS applicant_name, users.email, jobs.title AS job_title, applications.status, applications.application_date 
            FROM applications 
            JOIN users ON applications.user_id = users.id
            JOIN jobs ON applications.job_id = jobs.id
            ORDER BY applications.application_date DESC";
    $result = $conn->query($sql);
?>