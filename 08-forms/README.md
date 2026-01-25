# Day 08: Forms in PHP

## Learning Objectives
By the end of today, you will:
- Understand how HTML forms work with PHP
- Master `$_GET` and `$_POST` superglobals
- Handle form data securely
- Know when to use GET vs POST
- Build interactive web forms

---

## 1. How Forms Work

```
Form Submission Flow:

┌──────────────┐    HTTP Request     ┌──────────────┐
│    Browser   │ ─────────────────►  │  PHP Server  │
│  (HTML Form) │   Form Data         │  (process)   │
└──────────────┘                     └──────────────┘
                                            │
                     HTTP Response          │
                  ◄─────────────────────────┘
```

### Basic Form Structure
```html
<form action="process.php" method="POST">
    <input type="text" name="username">
    <input type="password" name="password">
    <button type="submit">Submit</button>
</form>
```

- **action**: PHP file that processes the form
- **method**: How data is sent (GET or POST)
- **name**: Key to access the value in PHP

---

## 2. $_GET Superglobal

GET sends data via URL query string.

### Example URL
```
http://example.com/search.php?query=php&page=1
```

### Accessing GET Data
```php
<?php
// URL: search.php?query=php&page=1

$query = $_GET['query'];  // "php"
$page = $_GET['page'];    // "1"

echo "Searching for: $query on page $page";
?>
```

### GET Form Example
```html
<!-- search.html -->
<form action="search.php" method="GET">
    <input type="text" name="q" placeholder="Search...">
    <button type="submit">Search</button>
</form>
```

```php
<?php
// search.php
if (isset($_GET['q'])) {
    $searchTerm = $_GET['q'];
    echo "Results for: " . htmlspecialchars($searchTerm);
}
?>
```

### When to Use GET
- Search queries
- Filtering/sorting
- Pagination
- Bookmarkable URLs
- Non-sensitive data

---

## 3. $_POST Superglobal

POST sends data in the request body (not visible in URL).

### POST Form Example
```html
<!-- login.html -->
<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>
```

```php
<?php
// login.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "Username: " . htmlspecialchars($username);
    // Never echo passwords!
}
?>
```

### When to Use POST
- Login forms
- Registration
- File uploads
- Any sensitive data
- Data that changes server state

---

## 4. GET vs POST Comparison

| Feature | GET | POST |
|---------|-----|------|
| Data in URL | Yes | No |
| Bookmarkable | Yes | No |
| Cached | Yes | No |
| Length limit | ~2000 chars | No limit |
| Security | Less secure | More secure |
| Idempotent | Yes | No |
| Use for | Search, filter | Login, submit |

---

## 5. Checking if Form Submitted

### Method 1: Check Request Method
```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted via POST
    $name = $_POST['name'] ?? '';
}
?>
```

### Method 2: Check if Variable Exists
```php
<?php
if (isset($_POST['submit'])) {
    // Submit button was clicked
    $name = $_POST['name'];
}
?>
```

### Method 3: Check Specific Field
```php
<?php
if (!empty($_POST['email'])) {
    // Email field has a value
    $email = $_POST['email'];
}
?>
```

---

## 6. Form Input Types

### Text Inputs
```html
<form method="POST" action="process.php">
    <!-- Text -->
    <input type="text" name="name">

    <!-- Email -->
    <input type="email" name="email">

    <!-- Password -->
    <input type="password" name="password">

    <!-- Number -->
    <input type="number" name="age" min="0" max="120">

    <!-- Textarea -->
    <textarea name="message" rows="5"></textarea>

    <!-- Hidden -->
    <input type="hidden" name="user_id" value="123">
</form>
```

### Selection Inputs
```html
<form method="POST">
    <!-- Select dropdown -->
    <select name="country">
        <option value="">Select country</option>
        <option value="us">United States</option>
        <option value="uk">United Kingdom</option>
        <option value="ca">Canada</option>
    </select>

    <!-- Radio buttons (single choice) -->
    <input type="radio" name="gender" value="male"> Male
    <input type="radio" name="gender" value="female"> Female

    <!-- Checkboxes (multiple choice) -->
    <input type="checkbox" name="interests[]" value="sports"> Sports
    <input type="checkbox" name="interests[]" value="music"> Music
    <input type="checkbox" name="interests[]" value="movies"> Movies
</form>
```

### Processing Select and Radio
```php
<?php
// Select and Radio - single value
$country = $_POST['country'] ?? '';
$gender = $_POST['gender'] ?? '';

echo "Country: $country, Gender: $gender";
?>
```

### Processing Checkboxes (Array)
```php
<?php
// Checkboxes - array of values
$interests = $_POST['interests'] ?? [];

echo "Interests: " . implode(", ", $interests);
// Output: Interests: sports, music
?>
```

---

## 7. Same Page Form Handling

Process form on the same page:

```php
<?php
$message = '';
$name = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';

    if (!empty($name)) {
        $message = "Hello, " . htmlspecialchars($name) . "!";
    } else {
        $message = "Please enter your name.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Form Example</title></head>
<body>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
```

---

## 8. $_REQUEST Superglobal

`$_REQUEST` contains both `$_GET` and `$_POST` data.

```php
<?php
// Works for both GET and POST
$value = $_REQUEST['field'] ?? '';
?>
```

**Note**: Prefer `$_GET` or `$_POST` explicitly for clarity and security.

---

## 9. File Uploads

```html
<!-- Must use enctype="multipart/form-data" -->
<form method="POST" action="upload.php" enctype="multipart/form-data">
    <input type="file" name="photo">
    <button type="submit">Upload</button>
</form>
```

```php
<?php
// upload.php
if (isset($_FILES['photo'])) {
    $file = $_FILES['photo'];

    echo "Name: " . $file['name'] . "\n";
    echo "Type: " . $file['type'] . "\n";
    echo "Size: " . $file['size'] . " bytes\n";
    echo "Temp: " . $file['tmp_name'] . "\n";
    echo "Error: " . $file['error'] . "\n";

    // Move to permanent location
    if ($file['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($file['tmp_name'], "uploads/" . $file['name']);
        echo "File uploaded successfully!";
    }
}
?>
```

---

## 10. Security Basics

### Always Escape Output
```php
<?php
// BAD - XSS vulnerability
echo $_POST['name'];

// GOOD - escaped
echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
?>
```

### Check Required Fields
```php
<?php
if (empty($_POST['email'])) {
    echo "Email is required";
}
?>
```

### Validate Data Types
```php
<?php
$age = $_POST['age'] ?? '';

if (!is_numeric($age) || $age < 0 || $age > 120) {
    echo "Invalid age";
}
?>
```

---

## 11. Complete Example

```php
<?php
$errors = [];
$success = false;
$data = [
    'name' => '',
    'email' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['message'] = trim($_POST['message'] ?? '');

    // Validate
    if (empty($data['name'])) {
        $errors[] = "Name is required";
    }

    if (empty($data['email'])) {
        $errors[] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($data['message'])) {
        $errors[] = "Message is required";
    }

    // Process if no errors
    if (empty($errors)) {
        // Save to database, send email, etc.
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Contact Form</title></head>
<body>
    <h1>Contact Us</h1>

    <?php if ($success): ?>
        <p style="color: green;">Thank you for your message!</p>
    <?php else: ?>

        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label>Name:</label><br>
                <input type="text" name="name"
                    value="<?php echo htmlspecialchars($data['name']); ?>">
            </div>

            <div>
                <label>Email:</label><br>
                <input type="email" name="email"
                    value="<?php echo htmlspecialchars($data['email']); ?>">
            </div>

            <div>
                <label>Message:</label><br>
                <textarea name="message"><?php echo htmlspecialchars($data['message']); ?></textarea>
            </div>

            <button type="submit">Send</button>
        </form>
    <?php endif; ?>
</body>
</html>
```

---

## 12. Key Takeaways

| Concept | Description |
|---------|-------------|
| `$_GET` | Data from URL query string |
| `$_POST` | Data from form body |
| `$_REQUEST` | Both GET and POST |
| `$_FILES` | Uploaded files |
| `$_SERVER['REQUEST_METHOD']` | Check if POST/GET |
| `isset()` | Check if field exists |
| `empty()` | Check if field is empty |
| `htmlspecialchars()` | Escape output for safety |

---

## 13. Building a Simple JSON API

Forms can also send data to APIs. Here's how PHP handles JSON requests:

### api.php - A Simple JSON API
```php
<?php
header('Content-Type: application/json');

// Handle JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Also accept form data
if (!$input) {
    $input = $_POST;
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $input['username'] ?? '';

    if (!empty($username)) {
        $response = [
            'success' => true,
            'message' => "Welcome, $username!",
            'data' => ['username' => $username]
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Username is required'
        ];
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $q = $_GET['q'] ?? '';

    if (!empty($q)) {
        $response = [
            'success' => true,
            'message' => "Search results for: $q",
            'data' => ['query' => $q]
        ];
    } else {
        $response = [
            'success' => true,
            'message' => 'API is running',
            'endpoints' => [
                'POST /' => 'Login with username and password',
                'GET /?q=term' => 'Search'
            ]
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
```

### Key Concepts

| Concept | Description |
|---------|-------------|
| `header('Content-Type: application/json')` | Tell browser to expect JSON |
| `file_get_contents('php://input')` | Read raw POST body |
| `json_decode()` | Convert JSON string to PHP array |
| `json_encode()` | Convert PHP array to JSON string |
| `JSON_PRETTY_PRINT` | Format JSON with indentation |

### Testing the API

```bash
# GET request - API info
curl http://localhost:8000/api.php

# GET request - Search
curl "http://localhost:8000/api.php?q=php"

# POST request - Login (JSON)
curl -X POST http://localhost:8000/api.php \
  -H "Content-Type: application/json" \
  -d '{"username": "john", "password": "secret"}'

# POST request - Login (form data)
curl -X POST http://localhost:8000/api.php \
  -d "username=john&password=secret"
```

### Sample Responses

**GET /** (no query):
```json
{
    "success": true,
    "message": "API is running",
    "endpoints": {
        "POST /": "Login with username and password",
        "GET /?q=term": "Search"
    }
}
```

**POST with username**:
```json
{
    "success": true,
    "message": "Welcome, john!",
    "data": {
        "username": "john"
    }
}
```

---

## 14. Homework

1. Create a simple contact form with name, email, and message
2. Build a search page using GET
3. Create a login form using POST
4. Make a survey with radio buttons and checkboxes

---

**← Previous:** Day 07 - Built-in Functions | **Next:** Day 09 - Form Validation →
