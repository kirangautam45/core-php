<?php
/**
 * Day 8: Forms in PHP
 * File 1: $_GET Method
 *
 * Run in browser: http://localhost/01-get-method.php
 * Or run: php -S localhost:8000 then visit http://localhost:8000/01-get-method.php
 */

// Process GET data
$searchQuery = '';
$category = '';
$page = 1;
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $searchQuery = htmlspecialchars(trim($_GET['q'] ?? ''));
    $category = htmlspecialchars($_GET['category'] ?? 'all');
    $page = (int)($_GET['page'] ?? 1);

    if ($page < 1) $page = 1;

    // Simulated search results
    if (!empty($searchQuery)) {
        $allResults = [
            ['title' => 'PHP Basics Tutorial', 'category' => 'tutorial'],
            ['title' => 'PHP Forms Guide', 'category' => 'tutorial'],
            ['title' => 'PHP Arrays Deep Dive', 'category' => 'article'],
            ['title' => 'Building Web Apps with PHP', 'category' => 'article'],
            ['title' => 'PHP Security Best Practices', 'category' => 'tutorial'],
        ];

        foreach ($allResults as $result) {
            if (stripos($result['title'], $searchQuery) !== false) {
                if ($category === 'all' || $result['category'] === $category) {
                    $results[] = $result;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - GET Method Example</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .search-box { background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        input[type="text"] { padding: 10px; width: 300px; font-size: 16px; }
        select { padding: 10px; font-size: 16px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .results { margin-top: 20px; }
        .result-item { padding: 15px; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 4px; }
        .result-item:hover { background: #f9f9f9; }
        .category { background: #e9ecef; padding: 2px 8px; border-radius: 3px; font-size: 12px; }
        .info { background: #e7f3ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        .url-display { background: #fff3cd; padding: 10px; border-radius: 4px; word-break: break-all; }
    </style>
</head>
<body>
    <h1>🔍 Search Example (GET Method)</h1>

    <div class="search-box">
        <form method="GET" action="">
            <input type="text" name="q" placeholder="Search for PHP tutorials..."
                   value="<?php echo htmlspecialchars($searchQuery); ?>">

            <select name="category">
                <option value="all" <?php echo $category === 'all' ? 'selected' : ''; ?>>All Categories</option>
                <option value="tutorial" <?php echo $category === 'tutorial' ? 'selected' : ''; ?>>Tutorials</option>
                <option value="article" <?php echo $category === 'article' ? 'selected' : ''; ?>>Articles</option>
            </select>

            <input type="hidden" name="page" value="1">

            <button type="submit">Search</button>
        </form>
    </div>

    <?php if (!empty($_GET['q'])): ?>
        <div class="url-display">
            <strong>Current URL:</strong><br>
            <code><?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></code>
        </div>

        <div class="results">
            <h2>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
            <p>Category: <?php echo htmlspecialchars($category); ?> | Page: <?php echo $page; ?></p>

            <?php if (empty($results)): ?>
                <p>No results found. Try searching for "PHP".</p>
            <?php else: ?>
                <?php foreach ($results as $result): ?>
                    <div class="result-item">
                        <strong><?php echo htmlspecialchars($result['title']); ?></strong>
                        <span class="category"><?php echo htmlspecialchars($result['category']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Enter a search term above. Try searching for "PHP" or "Forms".</p>
    <?php endif; ?>

    <hr style="margin-top: 40px;">

    <h3>$_GET Data (for debugging):</h3>
    <pre><?php print_r($_GET); ?></pre>

    <h3>Key Points about GET:</h3>
    <ul>
        <li>Data visible in URL</li>
        <li>Can be bookmarked</li>
        <li>Has length limits (~2000 chars)</li>
        <li>Good for: search, filters, pagination</li>
        <li>Access data: <code>$_GET['fieldname']</code></li>
    </ul>
</body>
</html>
