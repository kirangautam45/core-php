<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 05: Arrays in PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #666;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Day 05: Arrays in PHP</h1>

    <h2>Part 1: Indexed Arrays</h2>

    <h3>1.1 Creating & Accessing</h3>
    <pre><?php
$fruits = ["Apple", "Banana", "Cherry"];
echo $fruits[0] . "\n";
echo $fruits[1] . "\n";
echo $fruits[2] . "\n";
echo "Total: " . count($fruits) . "\n";
?></pre>

    <h3>1.2 Looping Through Arrays</h3>
    <pre><?php
$colors = ["Red", "Green", "Blue"];
foreach ($colors as $color) {
    echo "Color: $color\n";
}
?></pre>

    <h2>Part 2: Associative Arrays</h2>

    <h3>2.1 Creating & Accessing</h3>
    <pre><?php
$person = [
    "name" => "John",
    "age" => 25,
    "city" => "New York"
];
echo $person["name"] . "\n";
echo $person["age"] . " years old\n";
echo "Lives in " . $person["city"] . "\n";
?></pre>

    <h3>2.2 Looping Through Keys & Values</h3>
    <pre><?php
$product = [
    "name" => "Laptop",
    "price" => 999,
    "brand" => "Dell"
];
foreach ($product as $key => $value) {
    echo "$key: $value\n";
}
?></pre>

    <h2>Part 3: Nested Arrays</h2>

    <h3>3.1 Array of Records</h3>
    <pre><?php
$students = [
    ["name" => "Alice", "grade" => 85],
    ["name" => "Bob", "grade" => 92],
    ["name" => "Charlie", "grade" => 78]
];
foreach ($students as $student) {
    echo $student["name"] . ": " . $student["grade"] . "\n";
}
?></pre>

    <h3>3.2 Shopping Cart Example</h3>
    <pre><?php
$cart = [
    ["item" => "Laptop", "price" => 999],
    ["item" => "Mouse", "price" => 29],
    ["item" => "Keyboard", "price" => 79]
];
$total = 0;
foreach ($cart as $product) {
    echo $product["item"] . ": $" . $product["price"] . "\n";
    $total += $product["price"];
}
echo "---\nTotal: $" . $total . "\n";
?></pre>

    <h2>Part 4: Array Functions</h2>

    <h3>4.1 Check if Value Exists</h3>
    <pre><?php
$fruits = ["apple", "banana", "cherry"];
if (in_array("banana", $fruits)) {
    echo "Banana found!\n";
}
if (!in_array("grape", $fruits)) {
    echo "Grape not found\n";
}
?></pre>

    <h3>4.2 Sorting Arrays</h3>
    <pre><?php
$numbers = [5, 2, 8, 1, 9];
sort($numbers);
foreach ($numbers as $n) {
    echo "$n ";
}
echo "\n";
?></pre>

    <h3>4.3 Useful Functions</h3>
    <pre><?php
$scores = [85, 92, 78, 95, 88];
echo "Count: " . count($scores) . "\n";
echo "Sum: " . array_sum($scores) . "\n";
echo "Min: " . min($scores) . "\n";
echo "Max: " . max($scores) . "\n";
echo "Avg: " . (array_sum($scores) / count($scores)) . "\n";
?></pre>

    <h3>4.4 Array Map</h3>
    <pre><?php
$numbers = [1, 2, 3, 4, 5];
$doubled = array_map(function($n) {
    return $n * 2;
}, $numbers);
echo "Original: ";
print_r($numbers);
echo "Doubled: ";
print_r($doubled);
?></pre>

    <h3>4.5 Array Filter - Even Numbers</h3>
    <pre><?php
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$evens = array_filter($numbers, function($n) {
    return $n % 2 == 0;
});
echo "Even numbers:\n";
print_r($evens);
?></pre>

    <h3>4.6 Filter with Associative Arrays</h3>
    <pre><?php
$products = [
    ["name" => "Laptop", "price" => 999, "in_stock" => true],
    ["name" => "Phone", "price" => 699, "in_stock" => false],
    ["name" => "Tablet", "price" => 450, "in_stock" => true],
    ["name" => "Watch", "price" => 299, "in_stock" => false]
];

$available = array_filter($products, function($product) {
    return $product["in_stock"] == true;
});

echo "Available products:\n";
foreach ($available as $product) {
    echo "- " . $product["name"] . ": $" . $product["price"] . "\n";
}

$expensive = array_filter($products, function($product) {
    return $product["price"] > 500;
});

echo "\nExpensive products (>$500):\n";
foreach ($expensive as $product) {
    echo "- " . $product["name"] . ": $" . $product["price"] . "\n";
}
?></pre>

    <h3>4.7 Inventory Example</h3>
    <pre><?php
$inventory = [
    ["name" => "Shirt", "stock" => 10],
    ["name" => "Pants", "stock" => 0],
    ["name" => "Hat", "stock" => 5],
    ["name" => "Shoes", "stock" => 0]
];

$available = array_filter($inventory, function($item) {
    return $item["stock"] > 0;
});

echo "Available items:\n";
foreach ($available as $item) {
    echo "- " . $item["name"] . " (" . $item["stock"] . " in stock)\n";
}
?></pre>

</body>
</html>
