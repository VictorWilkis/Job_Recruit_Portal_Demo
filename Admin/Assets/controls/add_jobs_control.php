<?php
    // Database Connection
    require 'db_connect.php';

    $message = ""; // For success or error messages

    if (isset($_POST['submit'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $company = trim($_POST['company']);
            $location = trim($_POST['location']);
            $salary = trim($_POST['salary']);
            $required_skills = trim($_POST['skills']); // Store as comma-separated values
    
            // Insert job into database
            $stmt = $conn->prepare("INSERT INTO jobs (title, description, company, location, salary, required_skills) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssds", $title, $description, $company, $location, $salary, $required_skills);
    
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Job added successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error adding job!</div>";
            }
    
            $stmt->close();
        }

    }
    
?>