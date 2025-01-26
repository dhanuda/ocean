<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "registration_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$name = $_POST['name'];
$email = $_POST['email'];
$attachments = isset($_POST['attachments']) ? json_encode($_POST['attachments']) : null;

$sql = "INSERT INTO registrations (name, email, attachments) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $attachments);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Registration submitted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit registration']);
}
$stmt->close();
$conn->close();
?>