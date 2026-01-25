<?php
/**
 * Day 9: Form Validation & Sanitization
 * File 1: Validation Examples
 *
 * Run in browser: http://localhost/01-validation.php
 */

$errors = [];
$success = false;
$formData = [
    'name' => '',
    'email' => '',
    'age' => '',
    'phone' => '',
    'website' => '',
    'password' => '',
    'bio' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    foreach ($formData as $key => $value) {
        $formData[$key] = $_POST[$key] ?? '';
    }

    // ==========================
    // REQUIRED FIELD VALIDATION
    // ==========================
    if (empty(trim($formData['name']))) {
        $errors['name'] = "Name is required";
    } elseif (strlen($formData['name']) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    } elseif (strlen($formData['name']) > 50) {
        $errors['name'] = "Name cannot exceed 50 characters";
    }

    // ==========================
    // EMAIL VALIDATION
    // ==========================
    if (empty(trim($formData['email']))) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // ==========================
    // NUMBER VALIDATION
    // ==========================
    if (!empty($formData['age'])) {
        if (!is_numeric($formData['age'])) {
            $errors['age'] = "Age must be a number";
        } elseif ($formData['age'] < 1 || $formData['age'] > 120) {
            $errors['age'] = "Age must be between 1 and 120";
        }
    }

    // ==========================
    // PATTERN VALIDATION (PHONE)
    // ==========================
    if (!empty($formData['phone'])) {
        // Remove non-digits for comparison
        $phoneDigits = preg_replace('/[^0-9]/', '', $formData['phone']);
        if (strlen($phoneDigits) !== 10) {
            $errors['phone'] = "Phone must be 10 digits (e.g., 123-456-7890)";
        }
    }

    // ==========================
    // URL VALIDATION
    // ==========================
    if (!empty($formData['website'])) {
        if (!filter_var($formData['website'], FILTER_VALIDATE_URL)) {
            $errors['website'] = "Invalid URL format (include http:// or https://)";
        }
    }

    // ==========================
    // PASSWORD VALIDATION
    // ==========================
    if (empty($formData['password'])) {
        $errors['password'] = "Password is required";
    } else {
        $passwordErrors = [];
        if (strlen($formData['password']) < 8) {
            $passwordErrors[] = "at least 8 characters";
        }
        if (!preg_match('/[A-Z]/', $formData['password'])) {
            $passwordErrors[] = "one uppercase letter";
        }
        if (!preg_match('/[a-z]/', $formData['password'])) {
            $passwordErrors[] = "one lowercase letter";
        }
        if (!preg_match('/[0-9]/', $formData['password'])) {
            $passwordErrors[] = "one number";
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $formData['password'])) {
            $passwordErrors[] = "one special character";
        }

        if (!empty($passwordErrors)) {
            $errors['password'] = "Password must contain: " . implode(", ", $passwordErrors);
        }
    }

    // ==========================
    // LENGTH VALIDATION (BIO)
    // ==========================
    if (!empty($formData['bio'])) {
        if (strlen($formData['bio']) > 500) {
            $errors['bio'] = "Bio cannot exceed 500 characters";
        }
    }

    // Check if all validations passed
    if (empty($errors)) {
        $success = true;
    }
}

// Helper function to check if field has error
function hasError($field, $errors) {
    return isset($errors[$field]);
}

function getError($field, $errors) {
    return $errors[$field] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation Examples</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; padding: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ddd;
                         border-radius: 4px; box-sizing: border-box; }
        input.error, textarea.error { border-color: #dc3545; background: #fff5f5; }
        .error-message { color: #dc3545; font-size: 13px; margin-top: 5px; }
        .success { background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        button { padding: 12px 30px; background: #007bff; color: white; border: none;
                cursor: pointer; font-size: 16px; border-radius: 4px; }
        button:hover { background: #0056b3; }
        .hint { color: #6c757d; font-size: 12px; margin-top: 3px; }
        .required::after { content: " *"; color: #dc3545; }
        .char-count { text-align: right; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <h1>✅ Form Validation Examples</h1>

    <?php if ($success): ?>
        <div class="success">
            <strong>Success!</strong> All validations passed.
            <pre><?php print_r($formData); ?></pre>
        </div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <div class="form-group">
            <label class="required">Name (2-50 characters):</label>
            <input type="text" name="name"
                   class="<?php echo hasError('name', $errors) ? 'error' : ''; ?>"
                   value="<?php echo htmlspecialchars($formData['name']); ?>">
            <?php if (hasError('name', $errors)): ?>
                <div class="error-message"><?php echo getError('name', $errors); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="required">Email:</label>
            <input type="email" name="email"
                   class="<?php echo hasError('email', $errors) ? 'error' : ''; ?>"
                   value="<?php echo htmlspecialchars($formData['email']); ?>"
                   placeholder="example@email.com">
            <?php if (hasError('email', $errors)): ?>
                <div class="error-message"><?php echo getError('email', $errors); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Age (1-120):</label>
            <input type="number" name="age" min="1" max="120"
                   class="<?php echo hasError('age', $errors) ? 'error' : ''; ?>"
                   value="<?php echo htmlspecialchars($formData['age']); ?>">
            <?php if (hasError('age', $errors)): ?>
                <div class="error-message"><?php echo getError('age', $errors); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Phone (10 digits):</label>
            <input type="tel" name="phone"
                   class="<?php echo hasError('phone', $errors) ? 'error' : ''; ?>"
                   value="<?php echo htmlspecialchars($formData['phone']); ?>"
                   placeholder="123-456-7890">
            <?php if (hasError('phone', $errors)): ?>
                <div class="error-message"><?php echo getError('phone', $errors); ?></div>
            <?php endif; ?>
            <div class="hint">Format: 123-456-7890 or 1234567890</div>
        </div>

        <div class="form-group">
            <label>Website:</label>
            <input type="url" name="website"
                   class="<?php echo hasError('website', $errors) ? 'error' : ''; ?>"
                   value="<?php echo htmlspecialchars($formData['website']); ?>"
                   placeholder="https://example.com">
            <?php if (hasError('website', $errors)): ?>
                <div class="error-message"><?php echo getError('website', $errors); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="required">Password:</label>
            <input type="password" name="password"
                   class="<?php echo hasError('password', $errors) ? 'error' : ''; ?>">
            <?php if (hasError('password', $errors)): ?>
                <div class="error-message"><?php echo getError('password', $errors); ?></div>
            <?php endif; ?>
            <div class="hint">Min 8 chars, uppercase, lowercase, number, special char</div>
        </div>

        <div class="form-group">
            <label>Bio (max 500 characters):</label>
            <textarea name="bio" rows="4"
                      class="<?php echo hasError('bio', $errors) ? 'error' : ''; ?>"
                      maxlength="500"><?php echo htmlspecialchars($formData['bio']); ?></textarea>
            <?php if (hasError('bio', $errors)): ?>
                <div class="error-message"><?php echo getError('bio', $errors); ?></div>
            <?php endif; ?>
            <div class="char-count"><?php echo strlen($formData['bio']); ?>/500</div>
        </div>

        <button type="submit">Validate Form</button>
    </form>

    <hr style="margin: 40px 0;">
    <h2>Validation Rules Used:</h2>
    <ul>
        <li><strong>Name:</strong> Required, 2-50 characters</li>
        <li><strong>Email:</strong> Required, valid email format</li>
        <li><strong>Age:</strong> Optional, must be 1-120 if provided</li>
        <li><strong>Phone:</strong> Optional, must be 10 digits if provided</li>
        <li><strong>Website:</strong> Optional, must be valid URL if provided</li>
        <li><strong>Password:</strong> Required, 8+ chars, mixed case, number, special char</li>
        <li><strong>Bio:</strong> Optional, max 500 characters</li>
    </ul>
</body>
</html>
