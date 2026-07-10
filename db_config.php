<?php
$host = "localhost";
$database = "portfolio_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$database`");
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            local_id VARCHAR(50),
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    );
} catch (PDOException $error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $error->getMessage()
    ]);
    exit;
}
