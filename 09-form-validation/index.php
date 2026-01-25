<?php
/**
 * Day 09: Form Validation & Sanitization
 * A simple contact form with server-side validation
 */

// Initialize variables
$errors = [];
$success = false;
$name = '';
$email = '';
$message = '';

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Step 1: Get and trim input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Step 2: Validate each field

    // Name validation
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    }

    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address";
    }

    // Message validation
    if (empty($message)) {
        $errors['message'] = "Message is required";
    } elseif (strlen($message) < 10) {
        $errors['message'] = "Message must be at least 10 characters";
    }

    // Step 3: If no errors, process the form
    if (empty($errors)) {
        $success = true;
        // Here you would: save to database, send email, etc.

        // Clear form after success
        $name = $email = $message = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 09: Form Validation</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 { color: #333; }

        .form-group { margin-bottom: 15px; }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Error styling */
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .has-error input,
        .has-error textarea {
            border-color: #dc3545;
        }

        /* Success message */
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover { background: #0056b3; }

        /* Info box */
        .info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Contact Form</h1>

    <div class="info">
        <strong>Try these tests:</strong><br>
        1. Submit empty form<br>
        2. Enter invalid email (e.g., "abc")<br>
        3. Enter short name (1 character)<br>
        4. Try XSS: <code>&lt;script&gt;alert('hi')&lt;/script&gt;</code>
    </div>

    <?php if ($success): ?>
        <div class="success">
            <strong>Success!</strong> Your message has been sent.
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <!-- Name Field -->
        <div class="form-group <?= isset($errors['name']) ? 'has-error' : '' ?>">
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($name) ?>"
                placeholder="Enter your name"
            >
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Email Field -->
        <div class="form-group <?= isset($errors['email']) ? 'has-error' : '' ?>">
            <label for="email">Email</label>
            <input
                type="text"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email) ?>"
                placeholder="Enter your email"
            >
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Message Field -->
        <div class="form-group <?= isset($errors['message']) ? 'has-error' : '' ?>">
            <label for="message">Message</label>
            <textarea
                id="message"
                name="message"
                rows="4"
                placeholder="Enter your message (at least 10 characters)"
            ><?= htmlspecialchars($message) ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="error"><?= htmlspecialchars($errors['message']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Send Message</button>

    </form>

    <!-- Show what was submitted (for learning) -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <hr style="margin: 30px 0;">
        <h3>Debug Info:</h3>
        <pre style="background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto;"><?php
            echo "Submitted Data:\n";
            echo "Name: " . htmlspecialchars($_POST['name'] ?? '') . "\n";
            echo "Email: " . htmlspecialchars($_POST['email'] ?? '') . "\n";
            echo "Message: " . htmlspecialchars($_POST['message'] ?? '') . "\n\n";
            echo "Errors: " . (empty($errors) ? "None" : print_r($errors, true));
        ?></pre>
    <?php endif; ?>

</body>
</html>
