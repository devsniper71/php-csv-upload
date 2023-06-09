<?php
$servername = "localhost";
$username = "root";
$password = "pa55word";
$dbname = "dummy_csv_upload_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $createTableQuery = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20) NOT NULL,
        gender VARCHAR(10) NOT NULL,
        address VARCHAR(255) NOT NULL
    )";

    $conn->exec($createTableQuery);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
