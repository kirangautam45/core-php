<?php
/**
 * Day 20: Display Data in HTML Table
 *
 * Professional table display with formatting
 */

require_once 'db_config.php';

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

// Get statistics
$stats = $pdo->query("
    SELECT
        COUNT(*) as total,
        SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
        SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        AVG(age) as avg_age
    FROM users
")->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Display - Day 20</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Users Table Display</h1>

        <div class="nav">
            <a href="basic_fetch.php">Basic Fetch</a>
            <a href="table_display.php" class="active">Table Display</a>
            <a href="card_display.php">Card Display</a>
            <a href="search_filter.php">Search & Filter</a>
            <a href="pagination.php">Pagination</a>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-number"><?= $stats['total'] ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-number" style="color: #28a745;"><?= $stats['active'] ?></div>
                <div class="stat-label">Active</div>
            </div>
            <div class="stat-box">
                <div class="stat-number" style="color: #ffc107;"><?= $stats['pending'] ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-box">
                <div class="stat-number" style="color: #dc3545;"><?= $stats['inactive'] ?></div>
                <div class="stat-label">Inactive</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= round($stats['avg_age']) ?></div>
                <div class="stat-label">Avg Age</div>
            </div>
        </div>

        <!-- Users Table -->
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <p>No users found.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>City</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><strong><?= e($user['name']) ?></strong></td>
                        <td><?= e($user['email']) ?></td>
                        <td><?= e($user['age']) ?></td>
                        <td><?= e($user['city']) ?></td>
                        <td>
                            <?php
                            $roleColors = [
                                'admin' => '#dc3545',
                                'moderator' => '#17a2b8',
                                'user' => '#6c757d'
                            ];
                            $color = $roleColors[$user['role']] ?? '#6c757d';
                            ?>
                            <span style="color: <?= $color ?>; font-weight: 600;">
                                <?= ucfirst(e($user['role'])) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= $user['status'] ?>">
                                <?= e($user['status']) ?>
                            </span>
                        </td>
                        <td><?= formatDate($user['created_at']) ?></td>
                        <td>
                            <a href="single_record.php?id=<?= $user['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="info-box info">
            <strong>Tip:</strong> Click on "View" to see detailed information about each user.
        </div>

        <!-- Products Table -->
        <h2 style="margin-top: 40px;">Products Table</h2>
        <?php
        $products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 10")->fetchAll();
        ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Featured</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td>
                        <strong><?= e($product['name']) ?></strong>
                        <?php if ($product['is_featured']): ?>
                            <span style="color: #ffc107;">★</span>
                        <?php endif; ?>
                    </td>
                    <td><?= e($product['category']) ?></td>
                    <td class="price"><?= formatPrice($product['price']) ?></td>
                    <td>
                        <?php
                        $qtyClass = 'qty-high';
                        if ($product['quantity'] < 20) $qtyClass = 'qty-low';
                        elseif ($product['quantity'] < 50) $qtyClass = 'qty-medium';
                        ?>
                        <span class="<?= $qtyClass ?>"><?= $product['quantity'] ?></span>
                    </td>
                    <td><?= $product['is_featured'] ? '✓' : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
