# Day 05: Arrays in PHP

An array stores multiple values in one variable.

---

## Part 1: Indexed Arrays

Indexed arrays use numbers (0, 1, 2...) to access values.

### 1.1 Creating & Accessing
```php
$fruits = ["Apple", "Banana", "Cherry"];

echo $fruits[0] . "\n";
echo $fruits[1] . "\n";
echo $fruits[2] . "\n";
echo "Total: " . count($fruits);
```

**Explanation:**
- `$fruits = [...]` - Creates an array with 3 items
- `$fruits[0]` - Gets first item (Apple). Arrays start at 0, not 1!
- `$fruits[1]` - Gets second item (Banana)
- `$fruits[2]` - Gets third item (Cherry)
- `count($fruits)` - Returns how many items in array (3)

### 1.2 Looping Through Arrays
```php
$colors = ["Red", "Green", "Blue"];

foreach ($colors as $color) {
    echo "Color: $color\n";
}
```

**Explanation:**
- `foreach` - Loop that goes through each item in array
- `$colors as $color` - Each time through loop, `$color` holds current item
- First loop: `$color` = "Red"
- Second loop: `$color` = "Green"
- Third loop: `$color` = "Blue"

---

## Part 2: Associative Arrays

Associative arrays use names (strings) instead of numbers.

### 2.1 Creating & Accessing
```php
$person = [
    "name" => "John",
    "age" => 25,
    "city" => "New York"
];

echo $person["name"] . "\n";
echo $person["age"] . " years old\n";
echo "Lives in " . $person["city"];
```

**Explanation:**
- `"name" => "John"` - Key is "name", value is "John"
- `=>` - Arrow operator connects key to value
- `$person["name"]` - Gets value for key "name" (John)
- `$person["age"]` - Gets value for key "age" (25)
- More readable than `$person[0]`, `$person[1]`

### 2.2 Looping Through Keys & Values
```php
$product = [
    "name" => "Laptop",
    "price" => 999,
    "brand" => "Dell"
];

foreach ($product as $key => $value) {
    echo "$key: $value\n";
}
```

**Explanation:**
- `$key => $value` - Gets both key and value each loop
- First loop: `$key` = "name", `$value` = "Laptop"
- Second loop: `$key` = "price", `$value` = 999
- Third loop: `$key` = "brand", `$value` = "Dell"

---

## Part 3: Nested Arrays

Arrays inside arrays - useful for lists of records.

### 3.1 Array of Records
```php
$students = [
    ["name" => "Alice", "grade" => 85],
    ["name" => "Bob", "grade" => 92],
    ["name" => "Charlie", "grade" => 78]
];

foreach ($students as $student) {
    echo $student["name"] . ": " . $student["grade"] . "\n";
}
```

**Explanation:**
- `$students` - Array containing 3 arrays (3 student records)
- `$students[0]` - First student array `["name" => "Alice", "grade" => 85]`
- `$students[0]["name"]` - Gets "Alice"
- `foreach` gives us one student array each loop
- `$student["name"]` - Gets name from current student

### 3.2 Shopping Cart Example
```php
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
echo "---\nTotal: $" . $total;
```

**Explanation:**
- `$cart` - Array of products (each product is an array)
- `$total = 0` - Start total at zero
- `$total += $product["price"]` - Add each price to total
- `+=` means `$total = $total + $product["price"]`
- After loop, `$total` = 999 + 29 + 79 = 1107

---

## Part 4: Array Functions

Built-in functions to work with arrays.

### 4.1 Check if Value Exists
```php
$fruits = ["apple", "banana", "cherry"];

if (in_array("banana", $fruits)) {
    echo "Banana found!\n";
}

if (!in_array("grape", $fruits)) {
    echo "Grape not found";
}
```

**Explanation:**
- `in_array("banana", $fruits)` - Returns true if "banana" is in array
- `!in_array(...)` - The `!` means NOT (opposite)
- Use this to check before accessing a value

### 4.2 Sorting Arrays
```php
$numbers = [5, 2, 8, 1, 9];

sort($numbers);

foreach ($numbers as $n) {
    echo "$n ";
}
```

**Explanation:**
- `sort($numbers)` - Sorts array from smallest to largest
- Changes the original array (not a copy)
- After sort: [1, 2, 5, 8, 9]
- `rsort()` - Sorts in reverse (largest to smallest)

### 4.3 Useful Functions
```php
$scores = [85, 92, 78, 95, 88];

echo "Count: " . count($scores) . "\n";
echo "Sum: " . array_sum($scores) . "\n";
echo "Min: " . min($scores) . "\n";
echo "Max: " . max($scores) . "\n";
echo "Avg: " . array_sum($scores) / count($scores);
```

**Explanation:**
- `count($scores)` - Number of items (5)
- `array_sum($scores)` - Adds all values (85+92+78+95+88 = 438)
- `min($scores)` - Smallest value (78)
- `max($scores)` - Largest value (95)
- Average = sum / count = 438 / 5 = 87.6

### 4.4 Array Map
```php
$numbers = [1, 2, 3, 4, 5];

$doubled = array_map(function($n) {
    return $n * 2;
}, $numbers);

print_r($doubled);
```

**Explanation:**
- `array_map()` - Applies a function to each item in array
- `function($n)` - Anonymous function (no name)
- `$n * 2` - Doubles each number
- Returns NEW array: [2, 4, 6, 8, 10]
- Original array stays unchanged

---

## Quick Reference

| Function | What it does |
|----------|--------------|
| `count($arr)` | Number of items |
| `in_array($val, $arr)` | Check if value exists |
| `sort($arr)` | Sort ascending |
| `rsort($arr)` | Sort descending |
| `array_sum($arr)` | Add all values |
| `min($arr)` | Smallest value |
| `max($arr)` | Largest value |
| `array_map($fn, $arr)` | Apply function to each item |
