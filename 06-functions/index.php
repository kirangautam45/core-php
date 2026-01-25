<!DOCTYPE html>
<html>
<head>
    <title>Day 06: PHP Functions</title>
    <style>
        body {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            font-size: 18px;
        }
        h1 {
            text-align: center;
            font-size: 36px;
        }
        h3 {
            text-align: center;
            font-size: 24px;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 18px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<h1>Day 06: PHP Functions</h1>

<!-- 1. Basic Function -->
<h3>1. Basic Function</h3>
<pre><?php
function sayHello() {
    echo "Hello, World!\n";
}

sayHello();
sayHello();
?></pre>

<!-- 2. Function with Parameter -->
<h3>2. Function with Parameter</h3>
<pre><?php
function greet($name) {
    echo "Hello, $name!\n";
}

greet("Alice");
greet("Bob");
?></pre>

<!-- 3. Multiple Parameters -->
<h3>3. Multiple Parameters</h3>
<pre><?php
function introduce($name, $age) {
    echo "I'm $name, $age years old.\n";
}

introduce("Alice", 25);
introduce("Bob", 30);
?></pre>

<!-- 4. Default Parameter -->
<h3>4. Default Parameter</h3>
<pre><?php
function greetUser($name, $msg = "Hello") {
    echo "$msg, $name!\n";
}

greetUser("Alice");
greetUser("Bob", "Hi");
?></pre>

<!-- 5. Return Value -->
<h3>5. Return Value</h3>
<pre><?php
function add($a, $b) {
    return $a + $b;
}

$sum = add(5, 3);
echo "Sum: $sum\n";
echo "10 + 20 = " . add(10, 20);
?></pre>

<!-- 6. Pass by Reference -->
<h3>6. Pass by Reference</h3>
<pre><?php
function increment(&$def) {
    $def++;
}

$abc = 5;
echo "Before: $abc\n";
increment($abc);
echo "After: $abc\n";

// Without reference (original unchanged)
function incrementCopy($value) {
    $value++;
}

$num2 = 10;
echo "Without reference: $num2\n"; // Still 10
incrementCopy($num2);
echo "Without reference: $num2\n"; // Still 10
?></pre>

<!-- 7. Nullable Types -->
<h3>7. Nullable Types</h3>
<pre><?php
function findUser(?int $id): ?string {
    if ($id === null) {
        return null;
    }
    return "User #$id";
}

    echo findUser(1) . "\n";
    echo findUser(null) ?? "No user found";
echo "\n";

// Union types (PHP 8+)
function formatValue(int|string $value): string {
    return "Value: $value";
}

echo formatValue(42) . "\n";
echo formatValue("hello");
?></pre>

<!-- 8. Arrow Functions -->
<h3>8. Arrow Functions</h3>
<pre><?php
// Traditional anonymous function
$multiply = function($x, $y) {
    return $x * $y;
};
echo "Traditional: " . $multiply(3, 4) . "\n";

// Arrow function (shorter syntax)
$double = fn($x) => $x * 2;
echo "Double 5: " . $double(5) . "\n";

$add = fn($a, $b) => $a + $b;
echo "Add 3+7: " . $add(3, 7) . "\n";

// Arrow functions with arrays
$numbers = [1, 2, 3, 4, 5];
$squared = array_map(fn($n) => $n * $n, $numbers);
print_r($squared);
?></pre>

</body>
</html>
