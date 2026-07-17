<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Only POST requests are allowed."
    ]);
    exit;
}

require "db_config.php";

$localId = trim($_POST["local_id"] ?? "");
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $email === "" || $message === "") {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Please complete all fields."
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Please enter a valid email address."
    ]);
    exit;
}

try {
    $statement = $pdo->prepare(
        "INSERT INTO messages (local_id, name, email, message) VALUES (:local_id, :name, :email, :message)"
    );

    $statement->execute([
        ":local_id" => $localId,
        ":name" => $name,
        ":email" => $email,
        ":message" => $message
    ]);

    $emailSubject = "Portfolio Message from " . $name;
    $emailBody = "Name: " . $name . "\n";
    $emailBody .= "Email: " . $email . "\n\n";
    $emailBody .= "Message:\n" . $message;
    $headers = "Reply-To: " . $email . "\r\n";

    @mail("totoadriel8@gmail.com", $emailSubject, $emailBody, $headers);

    echo json_encode([
        "success" => true,
        "message" => "Message saved to MySQL.",
        "id" => $pdo->lastInsertId()
    ]);
} catch (PDOException $error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Could not save message to MySQL: " . $error->getMessage()
    ]);
}
