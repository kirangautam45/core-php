# Day 04: Loops in PHP

## Learning Objectives (50 minutes)

By the end of this session, you will:
- Understand why loops are essential in programming
- Master `for` and `foreach` loops (most commonly used)
- Know when to use `while` and `do-while`
- Control loop flow with `break` and `continue`

---

## Lesson Timeline

| Time | Topic |
|------|-------|
| 0-5 min | Why Loops? Introduction |
| 5-15 min | The `for` Loop |
| 15-22 min | The `while` Loop |
| 22-27 min | The `do-while` Loop |
| 27-37 min | The `foreach` Loop (Most Important!) |
| 37-42 min | `break` and `continue` |
| 42-50 min | Live Coding Exercise |

---

## 1. Why Loops? (5 min)

Without loops, you'd have to write repetitive code:

```php
<?php
// Without loops - repetitive and error-prone!
echo "Hello Student 1\n";
echo "Hello Student 2\n";
echo "Hello Student 3\n";
// ... imagine doing this 100 times!

// With loops - clean and efficient!
for ($i = 1; $i <= 100; $i++) {
    echo "Hello Student $i\n";
}
?>
```

**Real-world uses:**
- Processing all items in a shopping cart
- Sending emails to all subscribers
- Displaying all products from database
- Reading lines from a file

---

## 2. The `for` Loop (10 min)

**Use when:** You know exactly how many times to loop.

### Syntax
```php
for (start; condition; increment) {
    // code to repeat
}
```

### How It Works
```
┌─────────────────┐
│ 1. Initialize   │  ($i = 1)
└────────┬────────┘
         ▼
┌─────────────────┐
│ 2. Check        │◄─────────┐
│    Condition    │          │
└────────┬────────┘          │
    TRUE │ FALSE             │
         ▼      ▼            │
┌─────────────┐  Exit        │
│ 3. Run Code │              │
└──────┬──────┘              │
       ▼                     │
┌─────────────────┐          │
│ 4. Increment    │──────────┘
└─────────────────┘
```

### Examples

```php
<?php
// Count 1 to 5
for ($i = 1; $i <= 5; $i++) {
    echo "$i ";
}
// Output: 1 2 3 4 5

// Countdown
for ($i = 10; $i >= 1; $i--) {
    echo "$i... ";
}
echo "Blast off!";
// Output: 10... 9... 8... 7... 6... 5... 4... 3... 2... 1... Blast off!

// Skip by 2 (even numbers)
for ($i = 0; $i <= 10; $i += 2) {
    echo "$i ";
}
// Output: 0 2 4 6 8 10

// Multiplication table
$num = 5;
for ($i = 1; $i <= 10; $i++) {
    echo "$num x $i = " . ($num * $i) . "\n";
}
?>
```

---

## 3. The `while` Loop (7 min)

**Use when:** You don't know how many times to loop, but you have a condition.

### Syntax
```php
while (condition) {
    // code to repeat
}
```

### Examples

```php
<?php
// Basic counter
$count = 1;
while ($count <= 5) {
    echo "$count ";
    $count++;  // Don't forget this!
}
// Output: 1 2 3 4 5

// Real example: Double money with interest
$balance = 1000;
$years = 0;

while ($balance < 2000) {
    $balance = $balance * 1.10;  // 10% interest
    $years++;
}
echo "Money doubled in $years years";
// Output: Money doubled in 8 years

// Process until done
$tasks = ["Email", "Meeting", "Code Review"];

while (count($tasks) > 0) {
    $task = array_shift($tasks);  // Remove first item
    echo "Completed: $task\n";
}
?>
```

### Warning: Infinite Loop!
```php
<?php
// DANGER - This runs forever!
$i = 1;
while ($i <= 10) {
    echo $i;
    // Missing $i++ - never ends!
}
?>
```

---

## 4. The `do-while` Loop (5 min)

**Use when:** Code must run at least once, then check condition.

### Syntax
```php
do {
    // code to repeat (runs at least once!)
} while (condition);
```

### Key Difference from `while`

```php
<?php
$x = 100;

// while - checks FIRST, might not run
while ($x < 10) {
    echo "while: $x\n";  // Never prints!
}

// do-while - runs FIRST, then checks
do {
    echo "do-while: $x\n";  // Prints once!
} while ($x < 10);
?>
```

### Practical Example: Menu System

```php
<?php
do {
    echo "\n=== MENU ===\n";
    echo "1. View Profile\n";
    echo "2. Edit Settings\n";
    echo "3. Exit\n";
    echo "Choice: ";

    $choice = 3;  // Simulated input

    if ($choice == 1) echo "Showing profile...\n";
    if ($choice == 2) echo "Opening settings...\n";

} while ($choice != 3);

echo "Goodbye!";
?>
```

---

## 5. The `foreach` Loop - MOST IMPORTANT! (10 min)

**Use when:** Looping through arrays (you'll use this ALL the time!)

### Syntax
```php
// Values only
foreach ($array as $value) {
    // use $value
}

// Keys and values
foreach ($array as $key => $value) {
    // use $key and $value
}
```

### Example 1: Simple Array

```php
<?php
$fruits = ["Apple", "Banana", "Cherry"];

foreach ($fruits as $fruit) {
    echo "I like $fruit\n";
}
// Output:
// I like Apple
// I like Banana
// I like Cherry
?>
```

### Example 2: With Index

```php
<?php
$colors = ["Red", "Green", "Blue"];

foreach ($colors as $index => $color) {
    echo "$index: $color\n";
}
// Output:
// 0: Red
// 1: Green
// 2: Blue
?>
```

### Example 3: Associative Array

```php
<?php
$person = [
    "name" => "John",
    "age" => 25,
    "city" => "Mumbai"
];

foreach ($person as $key => $value) {
    echo "$key: $value\n";
}
// Output:
// name: John
// age: 25
// city: Mumbai
?>
```

### Example 4: Array of Arrays (Real-world!)

```php
<?php
$students = [
    ["name" => "Alice", "grade" => 85],
    ["name" => "Bob", "grade" => 92],
    ["name" => "Charlie", "grade" => 78]
];

foreach ($students as $student) {
    echo $student["name"] . " scored " . $student["grade"] . "%\n";
}
// Output:
// Alice scored 85%
// Bob scored 92%
// Charlie scored 78%
?>
```

### Example 5: Calculate Total

```php
<?php
$prices = [299, 199, 499, 149];
$total = 0;

foreach ($prices as $price) {
    $total += $price;
}

echo "Total: ₹$total";  // Total: ₹1146
?>
```

---

## 6. `break` and `continue` (5 min)

### `break` - Exit loop immediately

```php
<?php
// Find first even number and stop
$numbers = [1, 3, 5, 8, 9, 11];

foreach ($numbers as $num) {
    if ($num % 2 == 0) {
        echo "Found even: $num";
        break;  // Exit loop
    }
}
// Output: Found even: 8
?>
```

### `continue` - Skip to next iteration

```php
<?php
// Print only odd numbers
for ($i = 1; $i <= 10; $i++) {
    if ($i % 2 == 0) {
        continue;  // Skip even numbers
    }
    echo "$i ";
}
// Output: 1 3 5 7 9
?>
```

### Practical Example: Skip Invalid Data

```php
<?php
$scores = [85, -1, 92, 0, 78, -5, 88];

$total = 0;
$count = 0;

foreach ($scores as $score) {
    if ($score <= 0) {
        continue;  // Skip invalid scores
    }
    $total += $score;
    $count++;
}

echo "Average: " . ($total / $count);  // Average: 85.75
?>
```

---

## 7. Quick Reference: Which Loop to Use?

```
Need to loop through an array?
    └── YES → Use foreach

Know exactly how many times?
    └── YES → Use for

Must run at least once?
    └── YES → Use do-while

Don't know how many times?
    └── Use while
```

| Loop | Best For |
|------|----------|
| `for` | Counting, known iterations |
| `while` | Unknown iterations, check first |
| `do-while` | Must run once, menus, validation |
| `foreach` | Arrays (use this most!) |

---

## 8. Live Coding Exercise (8 min)

### Exercise 1: Sum 1 to 100
```php
<?php
$sum = 0;
for ($i = 1; $i <= 100; $i++) {
    $sum += $i;
}
echo "Sum of 1-100: $sum";  // 5050
?>
```

### Exercise 2: FizzBuzz (Classic!)
Print 1-20. For multiples of 3 print "Fizz", multiples of 5 print "Buzz", both print "FizzBuzz".

```php
<?php
for ($i = 1; $i <= 20; $i++) {
    if ($i % 3 == 0 && $i % 5 == 0) {
        echo "FizzBuzz ";
    } elseif ($i % 3 == 0) {
        echo "Fizz ";
    } elseif ($i % 5 == 0) {
        echo "Buzz ";
    } else {
        echo "$i ";
    }
}
// Output: 1 2 Fizz 4 Buzz Fizz 7 8 Fizz Buzz 11 Fizz 13 14 FizzBuzz 16 17 Fizz 19 Buzz
?>
```

### Exercise 3: Shopping Cart Total
```php
<?php
$cart = [
    ["item" => "Laptop", "price" => 50000],
    ["item" => "Mouse", "price" => 500],
    ["item" => "Keyboard", "price" => 1500]
];

$total = 0;
echo "Your Cart:\n";

foreach ($cart as $product) {
    echo "- " . $product["item"] . ": ₹" . $product["price"] . "\n";
    $total += $product["price"];
}

echo "Total: ₹$total";
?>
```

---

## 9. Common Mistakes to Avoid

```php
<?php
// MISTAKE 1: Infinite loop (missing increment)
$i = 1;
while ($i <= 10) {
    echo $i;
    // $i++ is missing!
}

// MISTAKE 2: Off-by-one error
$arr = [1, 2, 3];
for ($i = 0; $i <= count($arr); $i++) {  // Should be <, not <=
    echo $arr[$i];  // Error on last iteration!
}

// MISTAKE 3: Wrong loop choice
$fruits = ["Apple", "Banana"];
for ($i = 0; $i < count($fruits); $i++) {  // Works but...
    echo $fruits[$i];
}
// Better:
foreach ($fruits as $fruit) {  // Cleaner!
    echo $fruit;
}
?>
```

---

## 10. Key Takeaways

1. **`foreach`** is your best friend for arrays - use it most!
2. **`for`** when you know the count
3. **`while`** checks condition first
4. **`do-while`** runs at least once
5. **`break`** exits the loop
6. **`continue`** skips to next iteration
7. Always make sure loops can end (avoid infinite loops!)

---

## 11. Homework

1. **Star Pattern** - Print a right triangle of stars:
   ```
   *
   * *
   * * *
   * * * *
   * * * * *
   ```

2. **Find Maximum** - Loop through an array and find the largest number

3. **Reverse Print** - Print array elements in reverse order using a loop

4. **Grade Counter** - Count how many students passed (score >= 40) in an array of scores

---

**← Previous:** Day 03 - Operators & Conditionals | **Next:** Day 05 - Arrays →
