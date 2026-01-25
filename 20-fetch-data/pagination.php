<?php
/**
 * Day 20: Pagination
 *
 * Display data with page navigation
 */

require_once 'db_config.php';

// Pagination settings
$perPage = 10;
$page = max(1, (int)($_GET['page'] ?? 1));

// Get total count
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalPages = ceil($totalUsers / $perPage);

// Validate page number
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
}

// Calculate offset
$offset = ($page - 1) * $perPage;

// Fetch users for current page
$stmt = $pdo->prepare("SELECT * FROM users ORDER BY id LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

/**
 * Generate pagination HTML
 */
function renderPagination($currentPage, $totalPages, $range = 2) {
    if ($totalPages <= 1) return '';

    $html = '<div class="pagination">';

    // Previous button
    if ($currentPage > 1) {
        $html .= "<a href=\"?page=" . ($currentPage - 1) . "\">« Prev</a>";
    } else {
        $html .= "<span class=\"disabled\">« Prev</span>";
    }

    // First page
    if ($currentPage > $range + 1) {
        $html .= "<a href=\"?page=1\">1</a>";
        if ($currentPage > $range + 2) {
            $html .= "<span class=\"disabled\">...</span>";
        }
    }

    // Page numbers
    for ($i = max(1, $currentPage - $range); $i <= min($totalPages, $currentPage + $range); $i++) {
        if ($i == $currentPage) {
            $html .= "<span class=\"active\">$i</span>";
        } else {
            $html .= "<a href=\"?page=$i\">$i</a>";
        }
    }

    // Last page
    if ($currentPage < $totalPages - $range) {
        if ($currentPage < $totalPages - $range - 1) {
            $html .= "<span class=\"disabled\">...</span>";
        }
        $html .= "<a href=\"?page=$totalPages\">$totalPages</a>";
    }

    // Next button
    if ($currentPage < $totalPages) {
        $html .= "<a href=\"?page=" . ($currentPage + 1) . "\">Next »</a>";
    } else {
        $html .= "<span class=\"disabled\">Next »</span>";
    }

    $html .= '</div>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination - Day 20</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .page-info {
            text-align: center;
            margin: 20px 0;
            color: #666;
        }
        .per-page-form {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .per-page-form select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pagination Example</h1>

        <div class="nav">
            <a href="basic_fetch.php">Basic Fetch</a>
            <a href="table_display.php">Table Display</a>
            <a href="card_display.php">Card Display</a>
            <a href="search_filter.php">Search & Filter</a>
            <a href="sort_data.php">Sort Data</a>
            <a href="pagination.php" class="active">Pagination</a>
        </div>

        <!-- Page Info -->
        <div class="page-info">
            Showing <?= $offset + 1 ?> - <?= min($offset + $perPage, $totalUsers) ?>
            of <?= $totalUsers ?> users
            (Page <?= $page ?> of <?= $totalPages ?>)
        </div>

        <!-- Top Pagination -->
        <?= renderPagination($page, $totalPages) ?>

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
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><strong><?= e($user['name']) ?></strong></td>
                        <td><?= e($user['email']) ?></td>
                        <td><?= e($user['city']) ?></td>
                        <td>
                            <span class="badge badge-<?= $user['status'] ?>">
                                <?= e($user['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="single_record.php?id=<?= $user['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Bottom Pagination -->
        <?= renderPagination($page, $totalPages) ?>

        <!-- SQL Info -->
        <div class="info-box info" style="margin-top: 30px;">
            <strong>SQL Query:</strong>
            <pre style="margin-top: 10px; background: white; padding: 10px;">SELECT * FROM users ORDER BY id LIMIT <?= $perPage ?> OFFSET <?= $offset ?></pre>

            <strong>Pagination Formula:</strong>
            <ul style="margin-top: 10px;">
                <li>Total Pages = CEIL(Total Records / Per Page) = CEIL(<?= $totalUsers ?> / <?= $perPage ?>) = <?= $totalPages ?></li>
                <li>Offset = (Current Page - 1) × Per Page = (<?= $page ?> - 1) × <?= $perPage ?> = <?= $offset ?></li>
            </ul>
        </div>
    </div>
</body>
</html>
