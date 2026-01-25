# Day 06: PHP Functions

## Learning Objectives
By the end of today, you will:
- Understand what functions are and why they're useful
- Create custom functions with proper syntax
- Work with parameters and arguments
- Use return values effectively
- Understand variable scope
- Apply default parameters and type declarations

---

## 1. What is a Function?

A **function** is a reusable block of code that performs a specific task. Functions help you:
- Avoid repeating code (DRY - Don't Repeat Yourself)
- Organize code into logical units
- Make code easier to read and maintain
- Test individual pieces of functionality

```
Function Visualization:

┌─────────────────────────────────────┐
│           function greet            │
├─────────────────────────────────────┤
│  INPUT:    $name = "John"           │
│                                     │
│  PROCESS:  Build greeting message   │
│                                     │
│  OUTPUT:   "Hello, John!"           │
└─────────────────────────────────────┘
```

---

## 2. Function Syntax

### Basic Function
```php
<?php
    // Define a function
    function sayHello() {
        echo "Hello, World!\n";
    }

    // Call the function
    sayHello();  // Output: Hello, World!
    sayHello();  // Can call multiple times
?>
```

### Function Naming Rules
- Must start with a letter or underscore
- Can contain letters, numbers, underscores
- Case-insensitive (but use consistent naming)
- Use descriptive names (verb + noun pattern)

```php
<?php
    // Good function names
    function calculateTotal() { }
    function getUserById() { }
    function validateEmail() { }
    function sendNotification() { }

    // Bad function names
    function x() { }        // Not descriptive
    function doStuff() { }  // Too vague
?>
```

---

## 3. Function Parameters

Parameters allow you to pass data into functions.

### Single Parameter
```php
<?php
    function greet($name) {
        echo "Hello, $name!\n";
    }

    greet("Alice");  // Hello, Alice!
    greet("Bob");    // Hello, Bob!
?>
```

### Multiple Parameters
```php
<?php
    function introduce($name, $age, $city) {
        echo "$name is $age years old and lives in $city.\n";
    }

    introduce("Alice", 25, "New York");
    introduce("Bob", 30, "Los Angeles");
?>
```

### Default Parameter Values
```php
<?php
    function greet($name, $greeting = "Hello") {
        echo "$greeting, $name!\n";
    }

    greet("Alice");              // Hello, Alice!
    greet("Bob", "Good morning"); // Good morning, Bob!

    // Default parameters must come after required ones
    function createUser($name, $role = "user", $active = true) {
        echo "Created: $name, Role: $role, Active: " . ($active ? "Yes" : "No") . "\n";
    }

    createUser("Alice");                    // Uses defaults
    createUser("Bob", "admin");             // Custom role
    createUser("Charlie", "editor", false); // All custom
?>
```

---

## 4. Return Values

Functions can return data using the `return` statement.

### Basic Return
```php
<?php
    function add($a, $b) {
        return $a + $b;
    }

    $result = add(5, 3);
    echo $result;  // 8

    // Use return value directly
    echo add(10, 20);  // 30
?>
```

### Return Stops Execution
```php
<?php
    function checkAge($age) {
        if ($age < 0) {
            return "Invalid age";  // Function exits here
        }
        if ($age < 18) {
            return "Minor";
        }
        return "Adult";
    }

    echo checkAge(25);   // Adult
    echo checkAge(15);   // Minor
    echo checkAge(-5);   // Invalid age
?>
```

### Returning Different Types
```php
<?php
    function divide($a, $b) {
        if ($b === 0) {
            return null;  // Return null for error
        }
        return $a / $b;
    }

    $result = divide(10, 2);
    if ($result !== null) {
        echo "Result: $result\n";  // Result: 5
    }

    $result = divide(10, 0);
    if ($result === null) {
        echo "Cannot divide by zero\n";
    }
?>
```

### Returning Arrays
```php
<?php
    function getMinMax($numbers) {
        return [
            "min" => min($numbers),
            "max" => max($numbers)
        ];
    }

    $stats = getMinMax([5, 2, 9, 1, 7]);
    echo "Min: {$stats['min']}, Max: {$stats['max']}\n";
    // Min: 1, Max: 9
?>
```

---

## 5. Variable Scope

### Local Scope
Variables defined inside a function are local to that function.

```php
<?php
    function myFunction() {
        $localVar = "I'm local";
        echo $localVar;  // Works
    }

    myFunction();
    // echo $localVar;  // ERROR: Undefined variable
?>
```

### Global Scope
Variables defined outside functions are in the global scope.

```php
<?php
    $globalVar = "I'm global";

    function myFunction() {
        // Can't access $globalVar here by default
        global $globalVar;  // Now we can!
        echo $globalVar;
    }

    myFunction();  // I'm global
?>
```

### The `global` Keyword (Use Sparingly)
```php
<?php
    $counter = 0;

    function increment() {
        global $counter;
        $counter++;
    }

    increment();
    increment();
    echo $counter;  // 2
?>
```

### Better Approach: Pass and Return
```php
<?php
    function increment($counter) {
        return $counter + 1;
    }

    $counter = 0;
    $counter = increment($counter);
    $counter = increment($counter);
    echo $counter;  // 2
?>
```

---

## 6. Pass by Reference

By default, PHP passes arguments by value (a copy). Use `&` to pass by reference.

```php
<?php
    // Pass by value (default)
    function addFive($num) {
        $num += 5;
    }

    $value = 10;
    addFive($value);
    echo $value;  // Still 10!

    // Pass by reference
    function addFiveRef(&$num) {
        $num += 5;
    }

    $value = 10;
    addFiveRef($value);
    echo $value;  // Now 15!
?>
```

### Practical Use Case
```php
<?php
    function appendItem(&$array, $item) {
        $array[] = $item;
    }

    $fruits = ["Apple", "Banana"];
    appendItem($fruits, "Cherry");
    print_r($fruits);  // ["Apple", "Banana", "Cherry"]
?>
```

---

## 7. Type Declarations (PHP 7+)

### Parameter Types
```php
<?php
    function add(int $a, int $b): int {
        return $a + $b;
    }

    echo add(5, 3);    // 8
    // echo add("5", "3");  // Works due to type coercion

    // Strict mode
    declare(strict_types=1);

    function multiply(int $a, int $b): int {
        return $a * $b;
    }
?>
```

### Return Types
```php
<?php
    function getName(): string {
        return "John Doe";
    }

    function getAge(): int {
        return 25;
    }

    function isActive(): bool {
        return true;
    }

    function getScores(): array {
        return [85, 92, 78];
    }
?>
```

### Nullable Types
```php
<?php
    function findUser(int $id): ?array {
        // Return array or null
        if ($id > 0) {
            return ["id" => $id, "name" => "User $id"];
        }
        return null;
    }

    $user = findUser(1);   // ["id" => 1, "name" => "User 1"]
    $user = findUser(-1);  // null
?>
```

### Union Types (PHP 8+)
```php
<?php
    function processInput(int|string $input): string {
        return "Processed: $input";
    }

    echo processInput(42);       // Processed: 42
    echo processInput("hello");  // Processed: hello
?>
```

---

## 8. Variable-Length Arguments

### Using `...` (Splat Operator)
```php
<?php
    function sum(...$numbers) {
        $total = 0;
        foreach ($numbers as $num) {
            $total += $num;
        }
        return $total;
    }

    echo sum(1, 2, 3);        // 6
    echo sum(1, 2, 3, 4, 5);  // 15

    // Spread array into function
    $values = [10, 20, 30];
    echo sum(...$values);      // 60
?>
```

### Named Arguments (PHP 8+)
```php
<?php
    function createProduct($name, $price, $category = "General", $inStock = true) {
        return [
            "name" => $name,
            "price" => $price,
            "category" => $category,
            "inStock" => $inStock
        ];
    }

    // Using named arguments
    $product = createProduct(
        name: "Laptop",
        price: 999.99,
        inStock: false
    );
?>
```

---

## 9. Anonymous Functions (Closures)

```php
<?php
    // Anonymous function assigned to variable
    $greet = function($name) {
        return "Hello, $name!";
    };

    echo $greet("Alice");  // Hello, Alice!

    // As callback
    $numbers = [1, 2, 3, 4, 5];
    $squared = array_map(function($n) {
        return $n * $n;
    }, $numbers);
    print_r($squared);  // [1, 4, 9, 16, 25]
?>
```

### Arrow Functions (PHP 7.4+)
```php
<?php
    // Short syntax for simple functions
    $double = fn($n) => $n * 2;

    echo $double(5);  // 10

    $numbers = [1, 2, 3, 4, 5];
    $doubled = array_map(fn($n) => $n * 2, $numbers);
    print_r($doubled);  // [2, 4, 6, 8, 10]
?>
```

---

## 10. Practical Examples

### Example 1: Temperature Converter
```php
<?php
    function celsiusToFahrenheit(float $celsius): float {
        return ($celsius * 9/5) + 32;
    }

    function fahrenheitToCelsius(float $fahrenheit): float {
        return ($fahrenheit - 32) * 5/9;
    }

    echo celsiusToFahrenheit(0);    // 32
    echo celsiusToFahrenheit(100);  // 212
    echo fahrenheitToCelsius(98.6); // 37
?>
```

### Example 2: String Utilities
```php
<?php
    function slugify(string $text): string {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }

    function truncate(string $text, int $length = 100, string $suffix = "..."): string {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }

    echo slugify("Hello World!");  // hello-world
    echo truncate("This is a long text", 10);  // This is a...
?>
```

### Example 3: Array Helpers
```php
<?php
    function pluck(array $array, string $key): array {
        return array_map(fn($item) => $item[$key] ?? null, $array);
    }

    function groupBy(array $array, string $key): array {
        $result = [];
        foreach ($array as $item) {
            $groupKey = $item[$key] ?? 'other';
            $result[$groupKey][] = $item;
        }
        return $result;
    }

    $users = [
        ["name" => "Alice", "role" => "admin"],
        ["name" => "Bob", "role" => "user"],
        ["name" => "Charlie", "role" => "user"]
    ];

    $names = pluck($users, "name");  // ["Alice", "Bob", "Charlie"]
    $byRole = groupBy($users, "role");
?>
```

---

## 11. Common Mistakes

```php
<?php
    // MISTAKE 1: Forgetting return statement
    function addBad($a, $b) {
        $a + $b;  // Missing return!
    }
    $result = addBad(5, 3);  // $result is null

    // CORRECT
    function addGood($a, $b) {
        return $a + $b;
    }

    // MISTAKE 2: Default parameters before required
    // function bad($name = "Guest", $age) { }  // ERROR!

    // CORRECT
    function good($age, $name = "Guest") { }

    // MISTAKE 3: Modifying passed array without reference
    function addItemBad($arr, $item) {
        $arr[] = $item;  // Only modifies local copy
    }

    // CORRECT
    function addItemGood(&$arr, $item) {
        $arr[] = $item;
    }

    // MISTAKE 4: Using global when parameter is better
    // AVOID
    $config = ["debug" => true];
    function badDebug() {
        global $config;
        return $config["debug"];
    }

    // BETTER
    function goodDebug($config) {
        return $config["debug"];
    }
?>
```

---

## 12. Key Takeaways

| Concept | Description | Example |
|---------|-------------|---------|
| **Function** | Reusable code block | `function greet() { }` |
| **Parameter** | Input variable in definition | `function greet($name)` |
| **Argument** | Actual value passed | `greet("Alice")` |
| **Return** | Output value from function | `return $result;` |
| **Default Value** | Fallback if not provided | `$role = "user"` |
| **Type Declaration** | Enforce data types | `function add(int $a): int` |
| **Pass by Reference** | Modify original variable | `function inc(&$n)` |
| **Scope** | Where variables are accessible | Local vs Global |

---

## 13. Hands-On Exercises

### Exercise 1: Calculator Functions
Create functions for add, subtract, multiply, divide with error handling.

### Exercise 2: Array Statistics
Create functions to calculate mean, median, mode, and range.

### Exercise 3: String Validation
Create functions to validate email, phone number, and password strength.

### Exercise 4: User Management
Create functions to create, update, delete, and find users in an array.

---

## 14. Homework

1. Create a "Password Generator" function with configurable length and character types
2. Build a "BMI Calculator" with category classification
3. Write a "Text Analyzer" that counts words, sentences, and paragraphs
4. Create a "Date Helper" with functions for formatting and calculating differences

---

## 15. Examples in Code (index.php)

The accompanying `index.php` file demonstrates these concepts:

1. **Basic Function** - Simple `sayHello()` function with no parameters
2. **Function with Parameter** - `greet($name)` accepting a single argument
3. **Multiple Parameters** - `introduce($name, $age)` with two parameters
4. **Default Parameter** - `greetUser($name, $msg = "Hello")` with default value
5. **Return Value** - `add($a, $b)` returning the sum
6. **Pass by Reference** - `increment(&$value)` vs `incrementCopy($value)`
7. **Nullable Types** - `findUser(?int $id): ?string` and union types
8. **Arrow Functions** - Short syntax `fn($x) => $x * 2` and `array_map()` usage

---

**← Previous:** Day 05 - Arrays | **Next:** Day 07 - Built-in Functions →
