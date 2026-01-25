<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 07: Built-in PHP Functions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #f4f4f4;
        }
        .section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2 {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Day 07: Built-in PHP Functions</h1>

    <!-- STRING FUNCTIONS -->
    <div class="section">
        <h2>1. String Functions</h2>
        <pre><?php
$text = "Hello World";

// Length
echo "Length: " . strlen($text) . "\n";

// Uppercase & Lowercase
echo "Upper: " . strtoupper($text) . "\n";
echo "Lower: " . strtolower($text) . "\n";

// Substring
echo "First 5: " . substr($text, 0, 5) . "\n";

// Replace
echo "Replace: " . str_replace("World", "PHP", $text) . "\n";

// Position
echo "Position of 'World': " . strpos($text, "World") . "\n";

// Trim
$spaced = "   Hello  add.   ";
echo "Trimmed: '" . $spaced . "'\n";
echo "Trimmed: '" . trim($spaced) . "'\n";

// Split & Join
$fruits = "apple,banana,orange";
$arr = explode(",", $fruits);
echo "Explode: ";
print_r($arr);

//implode() is a PHP function that joins array elements into a single string with a separator.

$words = ["Hello", "World"];
echo "Implode: " . implode(" ", $words) . "\n";
?></pre>
    </div>

    <!-- MATH FUNCTIONS -->
    <div class="section">
        <h2>2. Math Functions</h2>
        <pre><?php
// Absolute value
echo "abs(-15): " . abs(-15) . "\n";

// Power & Square root
echo "pow(2, 8): " . pow(2, 8) . "\n";
echo "sqrt(144): " . sqrt(144) . "\n";

// Rounding
echo "round(4.7): " . round(4.7) . "\n";
echo "ceil(4.1): " . ceil(4.1) . "\n";
echo "floor(4.9): " . floor(4.9) . "\n";

// Min & Max
echo "min(2, 5, 1, 8): " . min(2, 5, 1, 8) . "\n";
echo "max(2, 5, 1, 8): " . max(2, 5, 1, 8) . "\n";

// Random
echo "rand(1, 100): " . rand(1, 100) . "\n";
?></pre>
    </div>

    <!-- DATE FUNCTIONS -->
    <div class="section">
        <h2>3. Date & Time Functions</h2>
        <pre><?php
// Current date & time
echo "date('Y-m-d'): " . date("Y-m-d") . "\n";
echo "date('H:i:s'): " . date("H:i:s") . "\n";
echo "date('Y-m-d H:i:s'): " . date("Y-m-d H:i:s") . "\n";
echo "date('F j, Y'): " . date("F j, Y") . "\n";

// Timestamp
echo "time(): " . time() . "\n";

// strtotime
echo "Next week: " . date("Y-m-d", strtotime("+1 week")) . "\n";
echo "Yesterday: " . date("Y-m-d", strtotime("-1 day")) . "\n";

// DateTime
$now = new DateTime();
echo "DateTime: " . $now->format("Y-m-d H:i:s") . "\n";
?></pre>
    </div>

    <!-- PRACTICAL EXAMPLE -->
    <div class="section">
        <h2>4. Practical Example: Text Formatter</h2>
        <pre><?php
function formatTitle($title) {
    return ucwords(strtolower(trim($title)));
}

function createSlug($name) {
    $name = strtolower(trim($name));
    $name = preg_replace('/[^a-z0-9]+/', '-', $name);
    return trim($name, '-');
}

// Test
$title = "  HELLO WORLD FROM PHP  ";
echo "Original: '" . $title . "'\n";
echo "Formatted: '" . formatTitle($title) . "'\n";
echo "Slug: '" . createSlug($title) . "'\n";
?></pre>
    </div>

    <!-- INCLUDE/REQUIRE -->
    <div class="section">
        <h2>5. Include & Require</h2>
        <pre><?php
echo "// Include - continues if file not found\n";
echo "include 'header.php';\n\n";

echo "// Require - stops if file not found\n";
echo "require 'config.php';\n\n";

echo "// Include once - prevents duplicates\n";
echo "include_once 'functions.php';\n\n";

echo "// Require once - best for config\n";
echo "require_once 'database.php';\n\n";

echo "// Use __DIR__ for reliable paths\n";
echo "require_once __DIR__ . '/config.php';\n";
?></pre>
    </div>

    <!-- DATE CALCULATOR EXAMPLE -->
    <div class="section">
        <h2>6. Date Calculator Example</h2>
        <pre><?php
function daysBetween($date1, $date2) {
    $d1 = new DateTime($date1);
    $d2 = new DateTime($date2);
    return $d1->diff($d2)->days;
}

function getAge($birthDate) {
    $birth = new DateTime($birthDate);
    $now = new DateTime();
    return $birth->diff($now)->y;
}

echo "Days between 2024-01-01 and 2024-12-31: ";
echo daysBetween("2024-01-01", "2024-12-31") . " days\n";

echo "Age from 1990-05-15: " . getAge("1990-05-15") . " years\n";
?></pre>
   

</body>
</html>
