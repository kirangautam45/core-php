# Day 09: Form Validation & Sanitization

## Learning Objectives
By the end of today, you will:
- Validate required fields
- Validate email, length, and format
- Sanitize user input to prevent attacks
- Understand the difference between validation and sanitization
- Build secure forms

---

## 1. Validation vs Sanitization

```
User Input: "  <script>alert('xss')</script>john@example.com  "

Validation: Is this a valid email? NO ❌
Sanitization: Clean it → "john@example.com" ✓

IMPORTANT: Always do BOTH!
```

| Concept | Purpose | Example |
|---------|---------|---------|
| **Validation** | Check if data is correct | Is email format valid? |
| **Sanitization** | Clean/escape data | Remove HTML tags |

---

## 2. Required Field Validation

```php
<?php
$errors = [];

// Check if field exists and has value
if (empty($_POST['name'])) {
    $errors[] = "Name is required";
}

// Using trim to handle whitespace-only input
$email = trim($_POST['email'] ?? '');
if (empty($email)) {
    $errors[] = "Email is required";
}

// Check multiple fields at once
$required = ['name', 'email', 'message'];
foreach ($required as $field) {
    if (empty(trim($_POST[$field] ?? ''))) {
        $errors[] = ucfirst($field) . " is required";
    }
}
?>
```

---

## 3. Email Validation

```php
<?php
$email = $_POST['email'] ?? '';

// Method 1: filter_var (recommended)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Method 2: Regular expression
$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
if (!preg_match($pattern, $email)) {
    $errors[] = "Invalid email format";
}

// Validate and sanitize together
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}
?>
```

---

## 4. Length Validation

```php
<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$bio = $_POST['bio'] ?? '';

// Minimum length
if (strlen($username) < 3) {
    $errors[] = "Username must be at least 3 characters";
}

// Maximum length
if (strlen($username) > 20) {
    $errors[] = "Username cannot exceed 20 characters";
}

// Range
if (strlen($password) < 8 || strlen($password) > 128) {
    $errors[] = "Password must be 8-128 characters";
}

// For multibyte (UTF-8) strings
if (mb_strlen($bio) > 500) {
    $errors[] = "Bio cannot exceed 500 characters";
}
?>
```

---

## 5. Number Validation

```php
<?php
$age = $_POST['age'] ?? '';
$price = $_POST['price'] ?? '';

// Check if numeric
if (!is_numeric($age)) {
    $errors[] = "Age must be a number";
}

// Validate integer in range
$age = filter_var($age, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 120]
]);
if ($age === false) {
    $errors[] = "Age must be between 1 and 120";
}

// Validate decimal/float
$price = filter_var($price, FILTER_VALIDATE_FLOAT);
if ($price === false || $price < 0) {
    $errors[] = "Invalid price";
}
?>
```

---

## 6. Pattern Validation (Regex)

```php
<?php
$phone = $_POST['phone'] ?? '';
$zipcode = $_POST['zipcode'] ?? '';
$username = $_POST['username'] ?? '';

// Phone number (US format)
if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone)) {
    $errors[] = "Phone must be in format: 123-456-7890";
}

// ZIP code (US)
if (!preg_match('/^\d{5}(-\d{4})?$/', $zipcode)) {
    $errors[] = "Invalid ZIP code";
}

// Username (alphanumeric + underscore)
if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    $errors[] = "Username: 3-20 characters, letters, numbers, underscore only";
}

// URL validation
$url = $_POST['website'] ?? '';
if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
    $errors[] = "Invalid URL format";
}
?>
```

---

## 7. Password Strength Validation

```php
<?php
function validatePassword($password) {
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Must be at least 8 characters";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Must contain uppercase letter";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Must contain lowercase letter";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Must contain a number";
    }
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "Must contain special character";
    }

    return $errors;
}

$passwordErrors = validatePassword($_POST['password'] ?? '');
if (!empty($passwordErrors)) {
    $errors = array_merge($errors, $passwordErrors);
}
?>
```

---

## 8. Sanitization Functions

### HTML Special Characters
```php
<?php
// Prevent XSS attacks
$userInput = '<script>alert("xss")</script>';

// Convert special characters to HTML entities
$safe = htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');
// Output: &lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;

// For output in HTML
echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
?>
```

### Strip Tags
```php
<?php
$input = '<p>Hello <script>evil()</script> World</p>';

// Remove all HTML tags
$clean = strip_tags($input);
// Output: Hello evil() World

// Allow specific tags
$clean = strip_tags($input, '<p><br><strong>');
// Output: <p>Hello evil() World</p>
?>
```

### Filter Functions
```php
<?php
// Sanitize string (strips tags and encodes special chars)
$clean = filter_var($input, FILTER_SANITIZE_STRING);  // Deprecated in PHP 8.1

// Sanitize email
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Sanitize URL
$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);

// Sanitize integer
$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

// Sanitize float
$price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT,
                    FILTER_FLAG_ALLOW_FRACTION);
?>
```

### Trim and Clean
```php
<?php
// Remove whitespace
$name = trim($_POST['name']);
$name = ltrim($name);  // Left trim
$name = rtrim($name);  // Right trim

// Remove specific characters
$phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
// "123-456-7890" → "1234567890"

// Normalize whitespace
$text = preg_replace('/\s+/', ' ', trim($_POST['text']));
?>
```

---

## 9. Complete Sanitization Function

```php
<?php
function sanitize($input, $type = 'string') {
    $input = trim($input);

    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_SANITIZE_EMAIL);

        case 'url':
            return filter_var($input, FILTER_SANITIZE_URL);

        case 'int':
            return filter_var($input, FILTER_SANITIZE_NUMBER_INT);

        case 'float':
            return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT,
                            FILTER_FLAG_ALLOW_FRACTION);

        case 'html':
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

        case 'string':
        default:
            // Remove tags and encode special chars
            return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}

// Usage
$name = sanitize($_POST['name']);
$email = sanitize($_POST['email'], 'email');
$age = sanitize($_POST['age'], 'int');
?>
```

---

## 10. Validation Helper Class

```php
<?php
class Validator {
    private $errors = [];
    private $data = [];

    public function __construct($data) {
        $this->data = $data;
    }

    public function required($field, $message = null) {
        $value = trim($this->data[$field] ?? '');
        if (empty($value)) {
            $this->errors[$field] = $message ?? "$field is required";
        }
        return $this;
    }

    public function email($field, $message = null) {
        $value = $this->data[$field] ?? '';
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?? "Invalid email format";
        }
        return $this;
    }

    public function minLength($field, $min, $message = null) {
        $value = $this->data[$field] ?? '';
        if (strlen($value) < $min) {
            $this->errors[$field] = $message ?? "$field must be at least $min characters";
        }
        return $this;
    }

    public function maxLength($field, $max, $message = null) {
        $value = $this->data[$field] ?? '';
        if (strlen($value) > $max) {
            $this->errors[$field] = $message ?? "$field cannot exceed $max characters";
        }
        return $this;
    }

    public function isValid() {
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}

// Usage
$validator = new Validator($_POST);
$validator
    ->required('name')
    ->required('email')
    ->email('email')
    ->minLength('password', 8);

if (!$validator->isValid()) {
    $errors = $validator->getErrors();
}
?>
```

---

## 11. Complete Form Example

```php
<?php
$errors = [];
$success = false;
$data = ['name' => '', 'email' => '', 'age' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $data['name'] = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $data['email'] = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $data['age'] = filter_var($_POST['age'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $data['message'] = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Validate
    if (empty($data['name'])) {
        $errors['name'] = "Name is required";
    } elseif (strlen($data['name']) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    }

    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (!empty($data['age'])) {
        $age = (int) $data['age'];
        if ($age < 1 || $age > 120) {
            $errors['age'] = "Age must be between 1 and 120";
        }
    }

    if (empty($data['message'])) {
        $errors['message'] = "Message is required";
    } elseif (strlen($data['message']) < 10) {
        $errors['message'] = "Message must be at least 10 characters";
    }

    // Process if valid
    if (empty($errors)) {
        $success = true;
        // Save to database, send email, etc.
    }
}
?>
```

---

## 12. Key Takeaways

| Function | Purpose |
|----------|---------|
| `empty()` | Check if value is empty |
| `isset()` | Check if variable exists |
| `trim()` | Remove whitespace |
| `strlen()` | Get string length |
| `filter_var()` | Validate and sanitize |
| `preg_match()` | Pattern matching |
| `htmlspecialchars()` | Prevent XSS |
| `strip_tags()` | Remove HTML tags |

### Validation Checklist
- ✓ Check required fields
- ✓ Validate email format
- ✓ Validate length limits
- ✓ Validate numeric ranges
- ✓ Check password strength
- ✓ Sanitize all output

---

## 13. Homework

1. Create a registration form with full validation
2. Build a password strength meter
3. Create a reusable validation function library
4. Add client-side validation alongside server-side

---

**← Previous:** Day 08 - Forms | **Next:** Day 10 - Mini Project →
