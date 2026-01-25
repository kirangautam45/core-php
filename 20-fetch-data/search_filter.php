<?php
/**
 * Day 20: Search and Filter Data
 *
 * Implementing search, filter, and multiple conditions
 */

require_once 'db_config.php';

// Get filter parameters
$search = trim($_GET['search'] ?? '');
$category = $_GET['category'] ?? '';
$minPrice = $_GET['min_price'] ?? '';
$maxPrice = $_GET['max_price'] ?? '';
$inStock = isset($_GET['in_stock']);

// Build query dynamically
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($search !== '') {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
}

if ($minPrice !== '') {
    $sql .= " AND price >= ?";
    $params[] = (float) $minPrice;
}

if ($maxPrice !== '') {
    $sql .= " AND price <= ?";
    $params[] = (float) $maxPrice;
}

if ($inStock) {
    $sql .= " AND quantity > 0";
}

$sql .= " ORDER BY name ASC";

// Execute query
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get categories for dropdown
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);

// Get price range
$priceRange = $pdo->query("SELECT MIN(price) as min, MAX(price) as max FROM products")->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search & Filter - Day 20</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .filter-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .filter-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .filter-group {
            flex: 1;
            min-width: 150px;
        }
        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 600;
        }
        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 0;
        }
        .checkbox-group input {
            width: auto;
        }
        .filter-buttons {
            display: flex;
            gap: 10px;
        }
        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .highlight {
            background: #fff3cd;
            padding: 2px 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search & Filter Products</h1>

        <div class="nav">
            <a href="basic_fetch.php">Basic Fetch</a>
            <a href="table_display.php">Table Display</a>
            <a href="card_display.php">Card Display</a>
            <a href="search_filter.php" class="active">Search & Filter</a>
            <a href="pagination.php">Pagination</a>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="filter-form">
            <div class="filter-row">
                <div class="filter-group" style="flex: 2;">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search"
                           value="<?= e($search) ?>"
                           placeholder="Search products...">
                </div>

                <div class="filter-group">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                                <?= e($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="min_price">Min Price</label>
                    <input type="number" id="min_price" name="min_price"
                           value="<?= e($minPrice) ?>"
                           placeholder="<?= formatPrice($priceRange['min']) ?>"
                           step="0.01" min="0">
                </div>

                <div class="filter-group">
                    <label for="max_price">Max Price</label>
                    <input type="number" id="max_price" name="max_price"
                           value="<?= e($maxPrice) ?>"
                           placeholder="<?= formatPrice($priceRange['max']) ?>"
                           step="0.01" min="0">
                </div>
            </div>

            <div class="filter-row" style="margin-top: 15px;">
                <div class="checkbox-group">
                    <input type="checkbox" id="in_stock" name="in_stock" <?= $inStock ? 'checked' : '' ?>>
                    <label for="in_stock">In Stock Only</label>
                </div>

                <div class="filter-buttons" style="margin-left: auto;">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="search_filter.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <!-- Results Info -->
        <div class="results-info">
            <span>
                Found <strong><?= count($products) ?></strong> products
                <?php if ($search): ?>
                    for "<strong><?= e($search) ?></strong>"
                <?php endif; ?>
            </span>
            <?php if ($search || $category || $minPrice || $maxPrice || $inStock): ?>
                <a href="search_filter.php">Clear all filters</a>
            <?php endif; ?>
        </div>

        <!-- Results Table -->
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <h3>No products found</h3>
                <p>Try adjusting your search or filter criteria.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Featured</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php
                            // Highlight search term
                            $name = e($product['name']);
                            if ($search) {
                                $name = preg_replace(
                                    '/(' . preg_quote(e($search), '/') . ')/i',
                                    '<span class="highlight">$1</span>',
                                    $name
                                );
                            }
                            echo $name;
                            ?>
                        </td>
                        <td><?= e($product['category']) ?></td>
                        <td class="price"><?= formatPrice($product['price']) ?></td>
                        <td>
                            <?php if ($product['quantity'] > 0): ?>
                                <span class="<?= $product['quantity'] < 30 ? 'qty-low' : 'qty-high' ?>">
                                    <?= $product['quantity'] ?> units
                                </span>
                            <?php else: ?>
                                <span class="qty-low">Out of Stock</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $product['is_featured'] ? '⭐' : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- SQL Query Display (for learning) -->
        <div class="info-box info" style="margin-top: 20px;">
            <strong>Generated SQL:</strong>
            <pre style="margin-top: 10px; background: white; padding: 10px;"><?= e($sql) ?></pre>
            <?php if (!empty($params)): ?>
                <strong>Parameters:</strong>
                <pre style="background: white; padding: 10px;"><?= e(implode(', ', $params)) ?></pre>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
