<?php
include "db_config.php";

// Validate input
if (!isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    die("Missing required fields");
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);

if (empty($name) || empty($email) || empty($message)) {
    die("All fields are required!");
}

// Use prepared statements
$sql = "INSERT INTO messages(name, email, message) VALUES(?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

if (mysqli_stmt_execute($stmt)) {
    echo "Message sent successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
