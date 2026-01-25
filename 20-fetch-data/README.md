# Day 20: Fetch & Display Data (50 min)

## ⏱️ Lesson Plan

| Time | Topic |
|------|-------|
| 0-5 min | Setup |
| 5-15 min | Fetch Methods |
| 15-30 min | Display in Tables |
| 30-40 min | Search & Filter |
| 40-50 min | Pagination |

---

## 🛠️ Setup (5 min)

### Database Connection
- **Username:** `test`
- **Password:** `test`
- **Database:** `day20_practice`

### Run the setup script
```bash
mysql -u test -ptest < days/day20/database_setup.sql
```

Or create sample data:
```sql
CREATE DATABASE IF NOT EXISTS day20_practice;
USE day20_practice;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    quantity INT DEFAULT 0
);

INSERT INTO products (name, price, category, quantity) VALUES
('Laptop', 999.99, 'Electronics', 10),
('Mouse', 29.99, 'Electronics', 50),
('Keyboard', 79.99, 'Electronics', 30),
('T-Shirt', 24.99, 'Clothing', 100),
('Jeans', 59.99, 'Clothing', 40),
('Book', 19.99, 'Books', 200);
```

---

## 📖 Fetch Methods (10 min)

### fetch() - One Row
```php
<?php
require 'db_config.php';

$stmt = $pdo->query("SELECT * FROM products LIMIT 1");
$product = $stmt->fetch();

echo $product['name'];  // "Laptop"
echo $product['price']; // 999.99
```

### fetchAll() - All Rows
```php
<?php
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

foreach ($products as $product) {
    echo $product['name'] . " - $" . $product['price'] . "<br>";
}
```

### fetchColumn() - Single Value
```php
<?php
// Count total products
$count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
echo "Total: $count products";

// Get one column value
$name = $pdo->query("SELECT name FROM products WHERE id = 1")->fetchColumn();
echo $name; // "Laptop"
```

---

## 📊 Display in Table (15 min)

### table_display.php
```php
<?php
require 'db_config.php';

$products = $pdo->query("SELECT * FROM products ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f5f5f5; }
        .price { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Products (<?= count($products) ?>)</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td class="price">$<?= number_format($p['price'], 2) ?></td>
                <td><?= $p['quantity'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
```

---

## 🔍 Search & Filter (10 min)

### search_filter.php
```php
<?php
require 'db_config.php';

// Get filter values
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// Build query
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}

if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$sql .= " ORDER BY name";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get categories for dropdown
$categories = $pdo->query("SELECT DISTINCT category FROM products")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Products</title>
    <style>
        .filters { margin-bottom: 20px; }
        .filters input, .filters select { padding: 8px; margin-right: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
    </style>
</head>
<body>
    <h1>Search Products</h1>

    <form method="GET" class="filters">
        <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">

        <select name="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat ?>" <?= $category === $cat ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Search</button>
        <a href="search_filter.php">Reset</a>
    </form>

    <p>Found: <?= count($products) ?> products</p>

    <table>
        <tr><th>Name</th><th>Category</th><th>Price</th></tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['category']) ?></td>
            <td>$<?= number_format($p['price'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
```

---

## 📄 Pagination (10 min)

### pagination.php
```php
<?php
require 'db_config.php';

// Settings
$perPage = 3;
$page = max(1, $_GET['page'] ?? 1);

// Get total count
$total = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalPages = ceil($total / $perPage);

// Get current page data
$offset = ($page - 1) * $perPage;
$stmt = $pdo->prepare("SELECT * FROM products LIMIT ? OFFSET ?");
$stmt->execute([$perPage, $offset]);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pagination</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        .pagination { display: flex; gap: 5px; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; }
        .pagination a:hover { background: #eee; }
        .pagination .active { background: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Products</h1>
    <p>Showing <?= $offset + 1 ?>-<?= min($offset + $perPage, $total) ?> of <?= $total ?></p>

    <table>
        <tr><th>ID</th><th>Name</th><th>Price</th></tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td>$<?= number_format($p['price'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">« Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Next »</a>
        <?php endif; ?>
    </div>
</body>
</html>
```

---

## 📝 Quick Reference

```php
// Fetch all rows
$rows = $pdo->query("SELECT * FROM table")->fetchAll();

// Fetch one row
$row = $pdo->query("SELECT * FROM table LIMIT 1")->fetch();

// Fetch single value
$count = $pdo->query("SELECT COUNT(*) FROM table")->fetchColumn();

// With parameters
$stmt = $pdo->prepare("SELECT * FROM table WHERE id = ?");
$stmt->execute([1]);
$row = $stmt->fetch();

// Search with LIKE
$stmt = $pdo->prepare("SELECT * FROM table WHERE name LIKE ?");
$stmt->execute(["%search%"]);

// Pagination formula
$offset = ($page - 1) * $perPage;
// LIMIT $perPage OFFSET $offset
```

---

## 🎯 Summary: Days 16-20

| Day | Topic | Key Skills |
|-----|-------|------------|
| 16 | Database Intro | Tables, Columns, Data Types |
| 17 | SQL CRUD | SELECT, INSERT, UPDATE, DELETE |
| 18 | PHP + MySQL | PDO Connection, Prepared Statements |
| 19 | Forms → DB | Validation, Insert from Forms |
| 20 | Display Data | Fetch, Tables, Search, Pagination |

---

## 📁 Files in This Directory

| File | Purpose |
|------|---------|
| `database_setup.sql` | Create sample database |
| `basic_fetch.php` | Fetch method examples |
| `table_display.php` | Display data in table |
| `search_filter.php` | Search and filter |
| `pagination.php` | Page navigation |

---

## ➡️ Next: Build a Complete CRUD Application!
