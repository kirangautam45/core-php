<?php
/**
 * Day 18: Database Configuration
 */

$host = 'localhost';
$dbname = 'day18_practice';
$username = 'data';
$password = 'data';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        $options
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
