<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 4: Loops in PHP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Day 4: Loops</h1>
        <p class="subtitle">Master iteration and repetition in PHP</p>

        <div class="section">
            <h2>1. Shopping Cart Total (foreach)</h2>
            <p>Calculate total price of items in a cart.</p>
            <div class="syntax">foreach ($cart as $item) { }</div>
            <div class="output">

<?php
$cart = [
    ["name" => "Laptop", "price" => 999],
    ["name" => "Mouse", "price" => 25],
    ["name" => "Keyboard", "price" => 75]
];
$total = 0;
foreach ($cart as $item) {
    echo $item["name"] . ": $" . $item["price"] . "<br>";
    $total += $item["price"];
}
echo "<strong>Total: $" . $total . "</strong>";
?>  
            </div>
        </div>

        <div class="section">
            <h2>2. Display User List (for)</h2>
            <p>Show a numbered list of users.</p>
            <div class="syntax">for ($i = 0; $i < count($users); $i++) { }</div>
            <div class="output">
<?php
$users = ["Alice", "Bob", "Charlie", "Diana"];
for ($i = 0; $i < count($users); $i++) {
    echo ($i + 1) . ". " . $users[$i] . "<br>";
}
?>
            </div>
        </div>

        <div class="section">
            <h2>3. Star Rating Display (nested loops)</h2>
            <p>Show star ratings for products.</p>
            <div class="syntax">foreach + for (nested loops)</div>
            <div class="output">
<?php
$products = [
    ["name" => "Phone", "rating" => 4],
    ["name" => "Tablet", "rating" => 5],
    ["name" => "Watch", "rating" => 3]
];
foreach ($products as $product) {
    echo $product["name"] . ": ";
    for ($i = 0; $i < $product["rating"]; $i++) {
        echo "★";
    }
    for ($i = $product["rating"]; $i < 5; $i++) {
        echo "☆";
    }
    echo "<br>";
}
?>
            </div>
        </div>
        <div class="section">
            <h2>4. Multiplication Table (for)</h2>
            <p>Generate a times table.</p>
            <div class="syntax">for ($i = 1; $i <= 10; $i++) { }</div>
            <div class="output">
<?php
$num = 5;
for ($i = 1; $i <= 10; $i++) {
    echo "$num x $i = " . ($num * $i) . "<br>";
}
?>
            </div>
        </div>

        <div class="section">
            <h2>5. Countdown Timer (while)</h2>
            <p>Countdown until launch.</p>
            <div class="syntax">while (condition) { }</div>
            <div class="output">
                <?php $n = 5; while ($n > 0) { echo "$n... "; $n--; } echo "Blast off!"; ?></div>
        </div>

        <div class="section">
            <h2>6. Password Retry (do...while)</h2>
            <p>Simulate password attempts - always asks at least once.</p>
            <div class="syntax">do { } while (condition);</div>
            <div class="output">
<?php
$correctPassword = "secret123";
$attempts = ["wrong1", "wrong2", "secret123"];
$index = 0;
do {
    $entered = $attempts[$index];
    echo "Attempt " . ($index + 1) . ": $entered";
    if ($entered === $correctPassword) {
        echo " ✓ Access granted!<br>";
    } else {
        echo " ✗ Wrong password<br>";
    }
    $index++;
} while ($entered !== $correctPassword && $index < count($attempts));
?>
            </div>
        </div>

        <div class="section">
            <h2>7. Skip Sold Out Items (continue)</h2>
            <p>Use continue to skip certain iterations.</p>
            <div class="syntax">continue; // skip to next iteration</div>
            <div class="output">
<?php
$inventory = [
    ["name" => "Shirt", "stock" => 10],
    ["name" => "Pants", "stock" => 0],
    ["name" => "Hat", "stock" => 5],
    ["name" => "Shoes", "stock" => 0]
];
echo "Available items:<br>";
foreach ($inventory as $item) {
    if ($item["stock"] == 0) continue;
    echo "- " . $item["name"] . " (" . $item["stock"] . " in stock)<br>";
}
?>
            </div>
        </div>

        <div class="section">
            <h2>8. Find First Match (break)</h2>
            <p>Use break to exit loop early when found.</p>
            <div class="syntax">break; // exit loop</div>
            <div class="output">
<?php
$orders = [
    ["id" => 101, "status" => "shipped"],
    ["id" => 102, "status" => "pending"],
    ["id" => 103, "status" => "pending"],
    ["id" => 104, "status" => "delivered"]
];
echo "Searching for pending order...<br>";
foreach ($orders as $order) {
    if ($order["status"] == "pending") {
        echo "Found: Order #" . $order["id"] . " is pending!";
        break;
    }
}
?>
            </div>
        </div>
    </div>
</body>
</html>
