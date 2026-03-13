<?php
// Load .env only if file exists (local development)
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $name = trim($parts[0]);
            $value = trim($parts[1]);
            // Remove surrounding quotes if they exist
            $value = trim($value, "\"'");
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
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
