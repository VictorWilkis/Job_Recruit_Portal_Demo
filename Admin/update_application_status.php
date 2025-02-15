<?php
session_start();
include 'Assets/controls/db_connect.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

// Validate POST data
if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

$application_id = intval($_POST['id']);
$new_status = $_POST['status'];

// Ensure status is valid
$allowed_statuses = ["Approved", "Rejected"];
if (!in_array($new_status, $allowed_statuses)) {
    echo json_encode(["success" => false, "message" => "Invalid status."]);
    exit();
}

// Check the current status
$check_stmt = $conn->prepare("SELECT status FROM applications WHERE id = ?");
$check_stmt->bind_param("i", $application_id);
$check_stmt->execute();
$check_stmt->bind_result($current_status);
$check_stmt->fetch();
$check_stmt->close();

// Prevent updating if already processed
if ($current_status !== "Pending") {
    echo json_encode(["success" => false, "message" => "This application has already been processed."]);
    exit();
}

// Update application status
$update_stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
$update_stmt->bind_param("si", $new_status, $application_id);

if ($update_stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Application status updated to " . $new_status]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update status."]);
}

$update_stmt->close();
$conn->close();
?>
