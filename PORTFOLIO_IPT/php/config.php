<?php
// config.php
// Edit these to match your DB credentials
$db_host = 'localhost';
$db_name = 'db_portfolio';
$db_user = 'root';
$db_pass = '';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // For production, don't echo details — log them.
    exit('Database connection failed: ' . $e->getMessage());
}
