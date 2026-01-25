# Day 03: Operators & Conditionals

## Learning Objectives
By the end of today, you will:
- Use arithmetic operators for calculations
- Understand == vs === comparison
- Apply logical operators (&&, ||, !)
- Write if/else/elseif statements
- Use the ternary operator

---

## 1. Arithmetic Operators

| Operator | Name | Example | Result |
|----------|------|---------|--------|
| `+` | Addition | `5 + 3` | `8` |
| `-` | Subtraction | `5 - 3` | `2` |
| `*` | Multiplication | `5 * 3` | `15` |
| `/` | Division | `15 / 3` | `5` |
| `%` | Modulus | `17 % 5` | `2` |
| `**` | Exponent | `2 ** 3` | `8` |

```php
<?php
    $a = 10;
    $b = 3;

    echo $a + $b;   // 13
    echo $a - $b;   // 7
    echo $a * $b;   // 30
    echo $a / $b;   // 3.33
    echo $a % $b;   // 1 (remainder)
    echo $a ** $b;  // 1000
?>
```

### Modulus - Check Even/Odd
```php
<?php
    $number = 7;
    if ($number % 2 == 0) {
        echo "even";
    } else {
        echo "odd";
    }
?>
```

---

## 2. Comparison: == vs ===

| Operator | Name | Description |
|----------|------|-------------|
| `==` | Loose | Compares VALUE only |
| `===` | Strict | Compares VALUE AND TYPE |

```php
<?php
    // LOOSE == (dangerous!)
    5 == "5"     // true (string converted)
    0 == false   // true

    // STRICT === (safe!)
    5 === "5"    // false (different types)
    5 === 5      // true
    0 === false  // false
?>
```

**Best Practice:** Always use `===` for comparisons.

### Other Comparison Operators
```php
<?php
    5 > 3    // true
    5 < 3    // false
    5 >= 5   // true
    5 <= 3   // false
    5 != 3   // true (not equal)
?>
```

---

## 3. Logical Operators

| Operator | Name | Description |
|----------|------|-------------|
| `&&` | AND | True if BOTH true |
| `\|\|` | OR | True if EITHER true |
| `!` | NOT | Inverts the value |

```php
<?php
    $age = 25;
    $hasLicense = true;

    // AND - both must be true
    if ($age >= 18 && $hasLicense) {
        echo "Can drive";
    }

    // OR - either can be true
    $isWeekend = false;
    $isHoliday = true;
    if ($isWeekend || $isHoliday) {
        echo "Day off!";
    }

    // NOT - inverts
    $isLoggedIn = false;
    if (!$isLoggedIn) {
        echo "Please log in";
    }
?>
```

---

## 4. Conditional Statements

### The if Statement
```php
<?php
    $age = 18;
    if ($age >= 18) {
        echo "You are an adult.";
    }
?>
```

### The if-else Statement
```php
<?php
    $temperature = 25;
    if ($temperature > 30) {
        echo "Hot!";
    } else {
        echo "Nice weather.";
    }
?>
```

### The elseif Statement
```php
<?php
    $score = 85;

    if ($score >= 90) {
        $grade = "A";
    } elseif ($score >= 80) {
        $grade = "B";
    } elseif ($score >= 70) {
        $grade = "C";
    } elseif ($score >= 60) {
        $grade = "D";
    } else {
        $grade = "F";
    }

    echo "Grade: $grade";  // B
?>
```

---

## 5. Ternary Operator

Shorthand for simple if-else:

```php
// Syntax: condition ? value_if_true : value_if_false
```

```php
<?php
    $age = 20;

    // Long way
    if ($age >= 18) {
        $status = "Adult";
    } else {
        $status = "Minor";
    }

    // Short way (ternary)
    $status = $age >= 18 ? "Adult" : "Minor";

    // Practical examples
    echo $isLoggedIn ? "Online" : "Offline";
    echo "You have $items " . ($items === 1 ? "item" : "items");
?>
```

---

## 6. Practice: Shopping Cart

```php
<?php
    $itemPrice = 29.99;
    $quantity = 3;
    $isMember = true;
    $discountRate = 0.10;
    $taxRate = 0.08;

    $subtotal = $itemPrice * $quantity;
    $discount = $isMember ? $subtotal * $discountRate : 0;
    $tax = ($subtotal - $discount) * $taxRate;
    $total = $subtotal - $discount + $tax;

    echo "Subtotal: $" . number_format($subtotal, 2);
    echo "Discount: -$" . number_format($discount, 2);
    echo "Tax: $" . number_format($tax, 2);
    echo "Total: $" . number_format($total, 2);
?>
```

---

## Key Takeaways

| Category | Operators |
|----------|-----------|
| Arithmetic | `+ - * / % **` |
| Comparison | `== === != !== > < >= <=` |
| Logical | `&& \|\| !` |
| Ternary | `?:` |

**Remember:**
- Use `===` instead of `==`
- Use `if/elseif/else` for conditions
- Ternary `?:` is a shortcut for simple if-else

---

**Previous:** Day 02 - Variables | **Next:** Day 04 - Loops
