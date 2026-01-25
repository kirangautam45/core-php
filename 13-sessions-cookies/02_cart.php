<?php
/**
 * DAY 13 - Part 2: Shopping Cart with Sessions
 * Time: 15 minutes
 *
 * Learning Goals:
 * - Store complex data in sessions
 * - Build a practical shopping cart
 * - Handle add/remove/update operations
 */

session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sample products (in real app, from database)
$products = [
    1 => ['name' => 'Laptop', 'price' => 999.99, 'image' => '💻'],
    2 => ['name' => 'Headphones', 'price' => 79.99, 'image' => '🎧'],
    3 => ['name' => 'Mouse', 'price' => 29.99, 'image' => '🖱️'],
    4 => ['name' => 'Keyboard', 'price' => 89.99, 'image' => '⌨️'],
    5 => ['name' => 'Monitor', 'price' => 349.99, 'image' => '🖥️'],
    6 => ['name' => 'USB Cable', 'price' => 9.99, 'image' => '🔌'],
];

$message = '';

// ============================================
// HANDLE CART ACTIONS
// ============================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = (int)($_POST['product_id'] ?? 0);

    switch ($action) {
        case 'add':
            if (isset($products[$productId])) {
                // Add to cart or increment quantity
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['qty']++;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'name' => $products[$productId]['name'],
                        'price' => $products[$productId]['price'],
                        'qty' => 1
                    ];
                }
                $message = "Added {$products[$productId]['name']} to cart!";
            }
            break;

        case 'remove':
            if (isset($_SESSION['cart'][$productId])) {
                $name = $_SESSION['cart'][$productId]['name'];
                unset($_SESSION['cart'][$productId]);
                $message = "Removed $name from cart.";
            }
            break;

        case 'update':
            $qty = (int)($_POST['qty'] ?? 0);
            if (isset($_SESSION['cart'][$productId])) {
                if ($qty <= 0) {
                    unset($_SESSION['cart'][$productId]);
                    $message = "Item removed.";
                } else {
                    $_SESSION['cart'][$productId]['qty'] = $qty;
                    $message = "Quantity updated.";
                }
            }
            break;

        case 'clear':
            $_SESSION['cart'] = [];
            $message = "Cart cleared!";
            break;
    }
}

// Calculate cart totals
$cartCount = 0;
$cartTotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartCount += $item['qty'];
    $cartTotal += $item['price'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 13: Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 { color: #333; }
        .message {
            background: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 20px;
        }
        @media (max-width: 768px) {
            .container { grid-template-columns: 1fr; }
        }

        /* Products Grid */
        .products {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .products h2 { margin-top: 0; }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 15px;
        }
        .product {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .product-icon { font-size: 2.5em; }
        .product-name { font-weight: bold; margin: 10px 0 5px; }
        .product-price { color: #4CAF50; font-weight: bold; }
        .btn-add {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }
        .btn-add:hover { background: #45a049; }

        /* Cart */
        .cart {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        .cart h2 {
            margin-top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-badge {
            background: #f44336;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8em;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .cart-item-info { flex: 1; }
        .cart-item-name { font-weight: bold; }
        .cart-item-price { color: #666; font-size: 0.9em; }
        .qty-input {
            width: 50px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-remove {
            background: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .cart-total {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #333;
            font-size: 1.2em;
            display: flex;
            justify-content: space-between;
        }
        .btn-clear {
            background: #ff9800;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
        }
        .empty-cart {
            text-align: center;
            color: #999;
            padding: 30px;
        }
    </style>
</head>
<body>
    <h1>🛒 Shopping Cart Demo</h1>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="container">
        <!-- Products -->
        <div class="products">
            <h2>Products</h2>
            <div class="product-grid">
                <?php foreach ($products as $id => $product): ?>
                    <div class="product">
                        <div class="product-icon"><?= $product['image'] ?></div>
                        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <button type="submit" class="btn-add">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Cart -->
        <div class="cart">
            <h2>
                Your Cart
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </h2>

            <?php if (empty($_SESSION['cart'])): ?>
                <div class="empty-cart">
                    Your cart is empty.<br>
                    Add some products!
                </div>
            <?php else: ?>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="cart-item-price">
                                $<?= number_format($item['price'], 2) ?> each
                            </div>
                        </div>

                        <!-- Quantity Update -->
                        <form method="POST" style="display: flex; align-items: center;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="number"
                                   name="qty"
                                   value="<?= $item['qty'] ?>"
                                   min="0"
                                   max="99"
                                   class="qty-input"
                                   onchange="this.form.submit()">
                        </form>

                        <!-- Remove Button -->
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <button type="submit" class="btn-remove">×</button>
                        </form>
                    </div>
                <?php endforeach; ?>

                <div class="cart-total">
                    <span>Total:</span>
                    <span>$<?= number_format($cartTotal, 2) ?></span>
                </div>

                <form method="POST">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn-clear">Clear Cart</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!--
    KEY TAKEAWAYS:

    1. Sessions can store complex data (arrays, nested arrays)
    2. Cart pattern: $_SESSION['cart'][$productId] = ['qty' => X, ...]
    3. Check isset() before accessing cart items
    4. Use unset() to remove specific items
    5. Cart persists across page loads (try refreshing!)
    -->
</body>
</html>
