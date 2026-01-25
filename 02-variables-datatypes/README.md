# Day 02: Variables & Data Types

## Learning Objectives

By the end of today, you will:

- Understand what variables are and how to create them
- Know the different data types in PHP
- Use debugging functions to inspect variables
- Apply variable naming conventions

---

## 1. What are Variables?

Variables are **containers for storing data**. Think of them as labeled boxes where you can put information.

```
┌─────────────────┐
│  $name          │  ← Variable name (label)
│  ┌───────────┐  │
│  │  "John"   │  │  ← Value (content)
│  └───────────┘  │
└─────────────────┘
```

### Basic Syntax

```php
<?php
    $variableName = "value";
?>
```

**Rules for variable names:**

- Must start with `$` sign
- Followed by letter or underscore (not number)
- Can contain letters, numbers, underscores
- Case-sensitive (`$name` and `$Name` are different!)

```php
<?php
    // Valid variable names
    $name = "John";
    $age = 25;
    $_private = "secret";
    $userName123 = "johndoe";

    // Invalid variable names
    $123name = "wrong";     // Can't start with number
    $user-name = "wrong";   // Can't use hyphen
    $user name = "wrong";   // Can't have spaces
?>
```

---

## 2. Data Types in PHP

PHP has 8 primitive data types. Let's focus on the 4 most common:

### String

Text wrapped in quotes.

```php
<?php
    $singleQuote = 'Hello World';
    $doubleQuote = "Hello World";

    // Difference: Double quotes can parse variables
    $name = "John";
    echo "Hello, $name";     // Output: Hello, John
    echo 'Hello, $name';     // Output: Hello, $name (literal)

    // Escape characters work in double quotes
    echo "Line 1\nLine 2";   // \n = new line
    echo "He said \"Hi\"";   // \" = quote character
?>
```

### Integer

Whole numbers (no decimals).

```php
<?php
    $positive = 42;
    $negative = -17;
    $zero = 0;

    // Different notations
    $decimal = 255;          // Normal decimal
    $octal = 0377;           // Octal (starts with 0)
    $hex = 0xFF;             // Hexadecimal (starts with 0x)
    $binary = 0b11111111;    // Binary (starts with 0b)

    // All above equal 255!
?>
```

### Float (Double)

Numbers with decimal points.

```php
<?php
    $price = 19.99;
    $pi = 3.14159;
    $negative = -2.5;

    // Scientific notation
    $big = 1.2e3;      // 1.2 × 10³ = 1200
    $small = 7.5e-2;   // 7.5 × 10⁻² = 0.075
?>
```

### Boolean

True or false values.

```php
<?php
    $isActive = true;
    $isDeleted = false;

    // Often used in conditions
    $isLoggedIn = true;
    if ($isLoggedIn) {
        echo "Welcome back!";
    }

    // These values are considered FALSE:
    // - false (boolean)
    // - 0 (integer)
    // - 0.0 (float)
    // - "" (empty string)
    // - "0" (string zero)
    // - [] (empty array)
    // - null
?>
```

### Array (Preview)

Collection of values (covered in depth on Day 6).

```php
<?php
    $colors = ["red", "green", "blue"];
    $person = [
        "name" => "John",
        "age" => 25
    ];
?>
```

### NULL

A variable with no value.

```php
<?php
    $empty = null;

    // Or unset a variable
    $name = "John";
    unset($name);  // $name is now undefined
?>
```

---

## 3. Checking Data Types

### gettype() - Get the type as string

```php
<?php
    $name = "John";
    $age = 25;
    $price = 19.99;
    $active = true;
    $empty = null;

    echo gettype($name);    // string
    echo gettype($age);     // integer
    echo gettype($price);   // double
    echo gettype($active);  // boolean
    echo gettype($empty);   // NULL
?>
```

### Type-checking functions

```php
<?php
    $value = "Hello";

    is_string($value);    // true
    is_int($value);       // false
    is_float($value);     // false
    is_bool($value);      // false
    is_null($value);      // false
    is_array($value);     // false
    is_numeric($value);   // false
    is_numeric("123");    // true (numeric string!)
?>
```

---

## 4. Debugging with var_dump() and print_r()

### var_dump() - Detailed information

```php
<?php
    $name = "John";
    $age = 25;
    $price = 19.99;
    $active = true;
    $colors = ["red", "green", "blue"];

    var_dump($name);
    // Output: string(4) "John"

    var_dump($age);
    // Output: int(25)

    var_dump($price);
    // Output: float(19.99)

    var_dump($active);
    // Output: bool(true)

    var_dump($colors);
    // Output: array(3) { [0]=> string(3) "red" [1]=> string(5) "green" [2]=> string(4) "blue" }
?>
```

### print_r() - Human-readable output (great for arrays)

```php
<?php
    $person = [
        "name" => "John",
        "age" => 25,
        "city" => "New York"
    ];

    print_r($person);
    /*
    Output:
    Array
    (
        [name] => John
        [age] => 25
        [city] => New York
    )
    */
?>
```

### Tip: Wrap in <pre> for better formatting

```php
<?php
    $data = ["apple", "banana", "cherry"];

    echo "<pre>";
    print_r($data);
    echo "</pre>";
?>
```

---

## 5. Variable Operations

### String Concatenation

```php
<?php
    $firstName = "John";
    $lastName = "Doe";

    // Using dot (.) operator
    $fullName = $firstName . " " . $lastName;
    echo $fullName;  // John Doe

    // Concatenation assignment (.=)
    $greeting = "Hello";
    $greeting .= " World";
    echo $greeting;  // Hello World
?>
```

### Variable in Strings (Interpolation)

```php
<?php
    $name = "John";
    $age = 25;

    // Double quotes allow variable interpolation
    echo "My name is $name and I am $age years old.";

    // For complex expressions, use curly braces
    $fruits = ["apple", "banana"];
    echo "I like {$fruits[0]}";

    // Object properties
    // echo "Name: {$user->name}";
?>
```

---

## 6. Type Juggling (Automatic Conversion)

PHP automatically converts types when needed:

```php
<?php
    // String to number
    $result = "10" + 5;
    var_dump($result);  // int(15)

    // Number to string
    $text = "Age: " . 25;
    var_dump($text);  // string(7) "Age: 25"

    // To boolean
    $empty = "";
    if ($empty) {
        echo "This won't print";  // Empty string is false
    }

    // Be careful!
    $weird = "10 apples" + 5;
    var_dump($weird);  // int(15) - PHP takes the leading number
?>
```

### Explicit Type Casting

```php
<?php
    $string = "42";

    $integer = (int) $string;      // 42
    $float = (float) $string;      // 42.0
    $boolean = (bool) $string;     // true
    $array = (array) $string;      // ["42"]

    var_dump($integer);  // int(42)
?>
```

---

## 7. Constants

Values that cannot change after being defined.

```php
<?php
    // Using define() - traditional way
    define("SITE_NAME", "My Website");
    define("MAX_USERS", 100);

    echo SITE_NAME;  // My Website (no $ sign!)

    // Using const - modern way (PHP 5.3+)
    const PI = 3.14159;
    const DEBUG_MODE = true;

    echo PI;  // 3.14159

    // Constants are global and case-sensitive by default
?>
```

### Built-in Constants

```php
<?php
    echo PHP_VERSION;      // Your PHP version
    echo PHP_INT_MAX;      // Maximum integer value
    echo __FILE__;         // Current file path
    echo __LINE__;         // Current line number
    echo __DIR__;          // Current directory
?>
```

---

## 8. Practice Examples

### Example 1: Personal Information

```php
<?php
    // Define personal information
    $name = "John Doe";
    $age = 25;
    $height = 5.9;  // in feet
    $isStudent = true;

    // Display with proper formatting
    echo "<h2>Personal Information</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Age:</strong> $age years old</p>";
    echo "<p><strong>Height:</strong> $height feet</p>";
    echo "<p><strong>Student:</strong> " . ($isStudent ? "Yes" : "No") . "</p>";

    // Debug
    echo "<h3>Debug Info:</h3>";
    echo "<pre>";
    var_dump($name, $age, $height, $isStudent);
    echo "</pre>";
?>
```

### Example 2: Shopping Cart Item

```php
<?php
    // Product details
    $productName = "Wireless Mouse";
    $price = 29.99;
    $quantity = 2;
    $inStock = true;

    // Calculate total
    $total = $price * $quantity;

    // Display
    echo "<div style='border: 1px solid #ccc; padding: 10px;'>";
    echo "<h3>$productName</h3>";
    echo "<p>Price: \$$price</p>";           // \$ escapes the dollar sign
    echo "<p>Quantity: $quantity</p>";
    echo "<p>Total: \$" . number_format($total, 2) . "</p>";
    echo "<p>Status: " . ($inStock ? "In Stock" : "Out of Stock") . "</p>";
    echo "</div>";
?>
```

### Example 3: Type Investigation

```php
<?php
    $values = [
        42,
        3.14,
        "Hello",
        true,
        null,
        [1, 2, 3]
    ];

    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Value</th><th>Type</th></tr>";

    foreach ($values as $val) {
        echo "<tr>";
        echo "<td>";
        var_dump($val);
        echo "</td>";
        echo "<td>" . gettype($val) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
?>
```

---

## 9. Hands-On Exercises

### Exercise 1: Variable Creation

Create a file with variables for:

- Your name (string)
- Your age (integer)
- Your height in meters (float)
- Whether you like PHP (boolean)
- Display all using `echo` with proper HTML formatting

### Exercise 2: Type Detective

Create an array with 5 different values of different types. Loop through and display each value's type using `gettype()`.

### Exercise 3: String Concatenation

Create variables for first name, last name, and city. Build a complete sentence using:

- Dot concatenation
- Variable interpolation (double quotes)

### Exercise 4: Calculator Variables

Create:

- Two number variables
- Calculate and store: sum, difference, product, quotient
- Display results with `var_dump()`

---

## 10. Common Mistakes

```php
<?php
    // WRONG: Missing $ sign
    // name = "John";  // Error!

    // WRONG: Spaces in variable name
    // $my name = "John";  // Error!

    // WRONG: Starting with number
    // $1stPlace = "Gold";  // Error!

    // WRONG: Single quotes don't parse variables
    $name = "John";
    echo 'Hello $name';  // Outputs: Hello $name

    // WRONG: Modifying a constant
    define("MAX", 100);
    // MAX = 200;  // Error!
?>
```

---

## 11. Key Takeaways

| Concept         | Example                   |
| --------------- | ------------------------- |
| Variable syntax | `$name = "value";`        |
| String          | `"Hello"` or `'Hello'`    |
| Integer         | `42`, `-17`               |
| Float           | `3.14`, `19.99`           |
| Boolean         | `true`, `false`           |
| NULL            | `null`                    |
| Check type      | `gettype($var)`           |
| Debug           | `var_dump($var)`          |
| Constant        | `define("NAME", "value")` |

---

## 12. Homework

1. Create a "profile card" that displays information about a fictional character using at least 4 different data types.

2. Experiment with type juggling: What happens when you add a string and an integer?

3. Create constants for your application settings (site name, version, debug mode).

---

**← Previous:** Day 01 - Environment Setup | **Next:** Day 03 - Operators →
