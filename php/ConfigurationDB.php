<?php
$host = 'mysql';
$db = 'test';
$user = 'root';
$pass = 'password';
$port = "3306";
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Error: Could not connect to database. " . $e->getMessage();
    exit();
}

try {
    $sql = "CREATE TABLE IF NOT EXISTS nbrb (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cur_id INT,
    date_object TIMESTAMP,
    cur_abbreviation VARCHAR(255) NOT NULL,
    cur_scale VARCHAR(255) NOT NULL,
    cur_name VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    cur_official_rate DECIMAL(10, 4) NOT NULL,
    date_of_request TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}