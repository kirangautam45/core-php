# Day 07: Built-in PHP Functions & Include/Require

## Learning Objectives

By the end of today, you will:

- Master essential string manipulation functions
- Work with mathematical functions
- Handle dates and times effectively
- Understand `include`, `require`, `include_once`, `require_once`
- Organize code using external files

---

## 1. String Functions

PHP provides powerful string manipulation functions.

### Length and Case

```php
<?php
    $str = "Hello World";

    // Length
    echo strlen($str);       // 11

    // Case conversion
    echo strtoupper($str);   // HELLO WORLD
    echo strtolower($str);   // hello world
    echo ucfirst("hello");   // Hello
    echo ucwords("hello world");  // Hello World
?>
```

### Search and Position

```php
<?php
    $str = "Hello World, Hello PHP";

    // Find position (0-indexed)
    echo strpos($str, "World");    // 6
    echo strpos($str, "Hello", 7); // 13 (start from position 7)
    echo strrpos($str, "Hello");   // 13 (last occurrence)

    // Check if contains (PHP 8+)
    var_dump(str_contains($str, "World"));  // true
    var_dump(str_starts_with($str, "Hello")); // true
    var_dump(str_ends_with($str, "PHP"));     // true
?>
```

### Substring and Replace

```php
<?php
    $str = "Hello World";

    // Extract substring
    echo substr($str, 0, 5);   // Hello
    echo substr($str, 6);      // World
    echo substr($str, -5);     // World (from end)

    // Replace
    echo str_replace("World", "PHP", $str);  // Hello PHP

    // Replace multiple
    $search = ["Hello", "World"];
    $replace = ["Hi", "PHP"];
    echo str_replace($search, $replace, $str);  // Hi PHP
?>
```

### Trim and Padding

```php
<?php
    $str = "   Hello World   ";

    // Trim whitespace
    echo trim($str);       // "Hello World"
    echo ltrim($str);      // "Hello World   "
    echo rtrim($str);      // "   Hello World"

    // Trim specific characters
    echo trim("###Hello###", "#");  // Hello

    // Padding
    echo str_pad("42", 5, "0", STR_PAD_LEFT);   // 00042
    echo str_pad("Hi", 10, "-", STR_PAD_BOTH);  // ----Hi----
?>
```

### Split and Join

```php
<?php
    // Split string into array
    $str = "apple,banana,cherry";
    $fruits = explode(",", $str);
    print_r($fruits);  // ["apple", "banana", "cherry"]

    // Join array into string
    $arr = ["Hello", "World"];
    echo implode(" ", $arr);  // Hello World

    // Split into characters
    $chars = str_split("Hello");
    print_r($chars);  // ["H", "e", "l", "l", "o"]
?>
```

### Formatting

```php
<?php
    // Printf-style formatting
    $name = "John";
    $age = 25;

    printf("Name: %s, Age: %d\n", $name, $age);

    // Return formatted string
    $formatted = sprintf("Price: $%.2f", 19.99);
    echo $formatted;  // Price: $19.99

    // Number formatting
    echo number_format(1234567.891, 2);  // 1,234,567.89
    echo number_format(1234567.891, 2, ",", " ");  // 1 234 567,89
?>
```

---

## 2. Math Functions

### Basic Math

```php
<?php
    // Absolute value
    echo abs(-15);     // 15

    // Power and square root
    echo pow(2, 8);    // 256
    echo sqrt(144);    // 12

    // Rounding
    echo round(4.5);   // 5
    echo round(4.567, 2);  // 4.57
    echo ceil(4.1);    // 5 (round up)
    echo floor(4.9);   // 4 (round down)

    // Min and Max
    echo min(2, 5, 1, 8);  // 1
    echo max(2, 5, 1, 8);  // 8
    echo min([2, 5, 1, 8]); // 1 (with array)
?>
```

### Random Numbers

```php
<?php
    // Random integer
    echo rand();           // Random number
    echo rand(1, 100);     // Random between 1-100

    // Better random (cryptographically secure)
    echo random_int(1, 100);

    // Shuffle array
    $arr = [1, 2, 3, 4, 5];
    shuffle($arr);
    print_r($arr);
?>
```

### Mathematical Constants and Functions

```php
<?php
    // Constants
    echo M_PI;      // 3.1415926535898
    echo M_E;       // 2.718281828...

    // Trigonometry
    echo sin(M_PI / 2);  // 1
    echo cos(0);         // 1
    echo tan(M_PI / 4);  // 1

    // Logarithms
    echo log(M_E);      // 1 (natural log)
    echo log10(100);    // 2

    // Modulo
    echo 17 % 5;        // 2
    echo fmod(17.5, 5); // 2.5 (float modulo)
?>
```

---

## 3. Date and Time Functions

### Current Date/Time

```php
<?php
    // Current timestamp
    echo time();  // Unix timestamp (seconds since 1970-01-01)

    // Formatted date
    echo date("Y-m-d");        // 2024-01-15
    echo date("H:i:s");        // 14:30:45
    echo date("F j, Y");       // January 15, 2024
    echo date("l, F jS, Y");   // Monday, January 15th, 2024
?>
```

### Date Format Characters

```
Y - 4-digit year (2024)
y - 2-digit year (24)
m - Month with zeros (01-12)
n - Month without zeros (1-12)
F - Full month name (January)
M - Short month name (Jan)
d - Day with zeros (01-31)
j - Day without zeros (1-31)
l - Full day name (Monday)
D - Short day name (Mon)
H - 24-hour with zeros (00-23)
G - 24-hour without zeros (0-23)
h - 12-hour with zeros (01-12)
g - 12-hour without zeros (1-12)
i - Minutes with zeros (00-59)
s - Seconds with zeros (00-59)
a - am/pm
A - AM/PM
```

### Working with Timestamps

```php
<?php
    // Create timestamp from date
    $timestamp = mktime(14, 30, 0, 12, 25, 2024);
    echo date("Y-m-d H:i:s", $timestamp);  // 2024-12-25 14:30:00

    // Parse string to timestamp
    $ts = strtotime("2024-12-25");
    echo date("l", $ts);  // Wednesday

    // Relative dates
    echo date("Y-m-d", strtotime("+1 week"));
    echo date("Y-m-d", strtotime("next Monday"));
    echo date("Y-m-d", strtotime("-3 days"));
    echo date("Y-m-d", strtotime("first day of next month"));
?>
```

### Date Calculations

```php
<?php
    // Days between dates
    $date1 = strtotime("2024-01-01");
    $date2 = strtotime("2024-12-31");
    $days = ($date2 - $date1) / (60 * 60 * 24);
    echo "$days days";  // 365 days

    // Using DateTime (recommended)
    $d1 = new DateTime("2024-01-01");
    $d2 = new DateTime("2024-12-31");
    $diff = $d1->diff($d2);
    echo $diff->days . " days";  // 365 days
    echo $diff->format("%y years, %m months, %d days");
?>
```

### DateTime Class

```php
<?php
    // Create DateTime
    $now = new DateTime();
    $date = new DateTime("2024-12-25");

    // Format
    echo $date->format("Y-m-d H:i:s");

    // Modify
    $date->modify("+1 month");
    $date->add(new DateInterval("P10D"));  // Add 10 days

    // Compare
    if ($now < $date) {
        echo "Date is in the future";
    }

    // Timezone
    $date = new DateTime("now", new DateTimeZone("America/New_York"));
    echo $date->format("Y-m-d H:i:s T");
?>
```

---

## 4. Include and Require

PHP allows you to include external files to organize and reuse code.

### Basic Include

```php
<?php
    // include - continues if file not found (warning)
    include "header.php";

    // require - stops if file not found (fatal error)
    require "config.php";

    // include_once - includes only once (prevents duplicates)
    include_once "functions.php";

    // require_once - requires only once
    require_once "database.php";
?>
```

### Difference Between Include and Require

| Feature        | include                       | require                      |
| -------------- | ----------------------------- | ---------------------------- |
| File not found | Warning, continues            | Fatal error, stops           |
| Use for        | Optional files (sidebar, ads) | Essential files (config, DB) |
| \_once variant | include_once                  | require_once                 |

### Practical Example: Project Structure

```
project/
├── includes/
│   ├── config.php
│   ├── functions.php
│   └── database.php
├── templates/
│   ├── header.php
│   └── footer.php
└── index.php
```

**config.php**

```php
<?php
define("SITE_NAME", "My Website");
define("SITE_URL", "https://example.com");
$config = [
    "debug" => true,
    "timezone" => "UTC"
];
?>
```

**functions.php**

```php
<?php
function formatPrice($price) {
    return "$" . number_format($price, 2);
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>
```

**header.php**

```php
<!DOCTYPE html>
<html>
<head>
    <title><?php echo SITE_NAME; ?></title>
</head>
<body>
    <header>
        <h1><?php echo SITE_NAME; ?></h1>
    </header>
```

**footer.php**

```php
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo SITE_NAME; ?></p>
    </footer>
</body>
</html>
```

**index.php**

```php
<?php
require_once "includes/config.php";
require_once "includes/functions.php";
include "templates/header.php";
?>

<main>
    <h2>Welcome!</h2>
    <p>Price: <?php echo formatPrice(99.99); ?></p>
</main>

<?php include "templates/footer.php"; ?>
```

### Include with Return Values

```php
<?php
// prices.php
return [
    "apple" => 1.50,
    "banana" => 0.75,
    "orange" => 2.00
];
?>

// main.php
<?php
$prices = include "prices.php";
print_r($prices);  // Array with prices
?>
```

### Using **DIR** for Reliable Paths

```php
<?php
// Always use __DIR__ for includes
require_once __DIR__ . "/includes/config.php";
require_once __DIR__ . "/includes/functions.php";

// __DIR__ = directory of current file
// __FILE__ = full path of current file
?>
```

---

## 5. Array Functions Quick Reference

```php
<?php
    $arr = [3, 1, 4, 1, 5, 9, 2, 6];

    // Count
    echo count($arr);  // 8

    // Sum and product
    echo array_sum($arr);      // 31
    echo array_product($arr);  // 0 (has 0? No, it's 6480)

    // Search
    var_dump(in_array(5, $arr));     // true
    echo array_search(5, $arr);      // 4 (index)

    // Sort
    sort($arr);           // Ascending
    rsort($arr);          // Descending
    asort($arr);          // Keep keys, sort by value
    ksort($arr);          // Sort by key

    // Merge and combine
    $merged = array_merge([1,2], [3,4]);  // [1,2,3,4]

    // Filter and map
    $evens = array_filter($arr, fn($n) => $n % 2 == 0);
    $doubled = array_map(fn($n) => $n * 2, $arr);

    // Unique and flip
    $unique = array_unique($arr);
    $flipped = array_flip($arr);  // Swap keys and values
?>
```

---

## 6. Practical Examples

### Example 1: Text Formatter

```php
<?php
function formatTitle($title) {
    return ucwords(strtolower(trim($title)));
}

function createSlug($name) {
    $name = strtolower(trim($name));
    $name = preg_replace('/[^a-z0-9]+/', '-', $name);
    return trim($name, '-');
}

function truncate($text, $length = 100, $suffix = "...") {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

echo formatTitle("  hELLO wORLD  ");  // Hello World
echo createSlug("Hello World! How are you?");  // hello-world-how-are-you
echo truncate("This is a very long text", 10);  // This is a...
?>
```

### Example 2: Date Utilities

```php
<?php
function formatDate($date, $format = "F j, Y") {
    return date($format, strtotime($date));
}

function daysUntil($targetDate) {
    $now = new DateTime();
    $target = new DateTime($targetDate);
    $diff = $now->diff($target);
    return $target > $now ? $diff->days : -$diff->days;
}

function isWeekend($date = null) {
    $day = date("N", $date ? strtotime($date) : time());
    return $day >= 6;
}

function getAge($birthDate) {
    $birth = new DateTime($birthDate);
    $now = new DateTime();
    return $birth->diff($now)->y;
}

echo formatDate("2024-12-25");  // December 25, 2024
echo daysUntil("2024-12-31") . " days until New Year";
echo isWeekend("2024-12-21") ? "Weekend" : "Weekday";  // Weekend
echo getAge("1990-05-15") . " years old";
?>
```

### Example 3: Math Utilities

```php
<?php
function percentage($value, $total) {
    return round(($value / $total) * 100, 2);
}

function randomString($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $result;
}

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
}

echo percentage(75, 200);  // 37.5
echo randomString(16);     // Random 16-char string
echo formatBytes(1536000); // 1.46 MB
?>
```

---

## 7. Common Mistakes

```php
<?php
    // MISTAKE 1: Case-sensitive function names for strings
    $pos = strPos("Hello", "e");  // Works (functions are case-insensitive)
    // But be consistent!

    // MISTAKE 2: Not checking if strpos returns false
    $str = "Hello World";
    if (strpos($str, "xyz")) {  // WRONG! Returns false, not 0
        echo "Found";
    }
    // CORRECT:
    if (strpos($str, "xyz") !== false) {
        echo "Found";
    }

    // MISTAKE 3: Wrong date format characters
    echo date("y-m-d");  // 24-01-15 (2-digit year!)
    echo date("Y-m-d");  // 2024-01-15 (correct)

    // MISTAKE 4: Include path issues
    include "config.php";  // May fail if not in same directory
    include __DIR__ . "/config.php";  // More reliable
?>
```

---

## 8. Key Takeaways

| Category    | Key Functions                                               |
| ----------- | ----------------------------------------------------------- |
| **String**  | strlen, substr, strpos, str_replace, explode, implode, trim |
| **Math**    | abs, round, ceil, floor, rand, min, max, pow, sqrt          |
| **Date**    | date, time, strtotime, mktime, DateTime class               |
| **Include** | include, require, include_once, require_once                |

---

**← Previous:** Day 06 - Functions | **Next:** Day 08 - Forms →
