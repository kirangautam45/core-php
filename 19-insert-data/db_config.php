<?php
/**
 * Day 19: Database Configuration
 */

$pdo = new PDO(
    "mysql:host=localhost;dbname=day19_practice;charset=utf8mb4",
    "data", "data",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
