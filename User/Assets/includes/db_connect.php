<?php
    // Database configurations (use .env or environment variables in production)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "job_recruit";


    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set character encoding (UTF-8) for security
    $conn->set_charset("utf8mb4");



?>


