<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env only if file exists (local development)
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Check if DATABASE_URL is set
    if (!isset($_ENV['DATABASE_URL'])) {
        throw new Exception("DATABASE_URL environment variable is not set.");
    }
    
    // Parse the DATABASE_URL (postgresql://user:password@host:port/dbname)
    $dbUrl = parse_url($_ENV['DATABASE_URL']);
    
    if (!$dbUrl || !isset($dbUrl['host'], $dbUrl['user'], $dbUrl['pass'])) {
        throw new Exception("Invalid DATABASE_URL format.");
    }
    
    // Build PDO DSN from parsed URL
    $dsn = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s",
        $dbUrl['host'],
        $dbUrl['port'] ?? 5432,
        ltrim($dbUrl['path'] ?? '/postgres', '/')
    );
    
    // Create PDO connection with username and password
    $pdo = new PDO($dsn, $dbUrl['user'], $dbUrl['pass'], $options);
    
} catch (\Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
