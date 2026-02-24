<?php
$host = 'localhost';
$dbname = 'school_db';
$charset='utf8mb4';
$username = 'data';
$password = 'data';

try {
    $pdo =new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "Database connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
