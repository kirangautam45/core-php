<!-- /**
 * Day 10: Mini Project - Safe Contact Form
 * File 1: Complete Working Solution
 *
 * Run in browser: http://localhost/01-contact-form.php
 *
 * This form demonstrates:
 * - Form handling with POST
 * - Input validation
 * - Output sanitization (XSS prevention)
 * - Sticky form values
 * - Error and success handling
 */ -->

<?php

// Initialize variables
$name = '';
$email = '';
$subject = '';
$message = '';
$errors = [];
$success = false;
$submittedData = null;

// Subject options
$subjectOptions = [
    '' => '-- Select a subject --',
    'general' => 'General Inquiry',
    'support' => 'Technical Support',
    'feedback' => 'Feedback',
    'billing' => 'Billing Question',
    'other' => 'Other'
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ========================================
    // STEP 1: GET AND TRIM INPUT
    // ========================================
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = $_POST['subject'] ?? '';
    $message = trim($_POST['message'] ?? '');

    // ========================================
    // STEP 2: VALIDATE ALL FIELDS
    // ========================================

    // Validate Name
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters';
    } elseif (strlen($name) > 50) {
        $errors['name'] = 'Name must be less than 50 characters';
    }

    // Validate Email
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    // Validate Subject
    if (empty($subject)) {
        $errors['subject'] = 'Please select a subject';
    } elseif (!array_key_exists($subject, $subjectOptions)) {
        $errors['subject'] = 'Invalid subject selected';
    }

    // Validate Message
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Message must be at least 10 characters';
    } elseif (strlen($message) > 1000) {
        $errors['message'] = 'Message must be less than 1000 characters';
    }

    // ========================================
    // STEP 3: PROCESS IF NO ERRORS
    // ========================================
    if (empty($errors)) {
        $success = true;

        // Store submitted data for display
        $submittedData = [
            'name' => $name,
            'email' => $email,
            'subject' => $subjectOptions[$subject],
            'message' => $message,
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        // In a real application, you would:
        // - Save to database
        // - Send email notification/tost message
        // - Log the submission

        // Clear form after successful submission
        $name = '';
        $email = '';
        $subject = '';
        $message = '';
    }
}

/**
 * Helper function to safely output user input
 * This prevents XSS attacks
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Helper function to check if field has error
 */
function hasError($field, $errors) {
    return isset($errors[$field]);
}

/**
 * Helper function to get error message
 */
function getError($field, $errors) {
    return $errors[$field] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form - Day 10 Mini Project</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-top: 0;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        label .required {
            color: #dc3545;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s;
        }
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        input.error,
        select.error,
        textarea.error {
            border-color: #dc3545;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .char-count {
            font-size: 12px;
            color: #666;
            text-align: right;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 14px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .submitted-data {
            background: #e7f3ff;
            border: 1px solid #b6d4fe;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }
        .submitted-data h3 {
            margin-top: 0;
            color: #0c5460;
        }
        .submitted-data table {
            width: 100%;
            border-collapse: collapse;
        }
        .submitted-data th,
        .submitted-data td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #b6d4fe;
        }
        .submitted-data th {
            width: 30%;
            color: #0c5460;
        }
        .submitted-data td {
            color: #333;
        }
        .test-inputs {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .test-inputs h4 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .test-inputs button {
            width: auto;
            padding: 8px 15px;
            font-size: 14px;
            margin: 5px;
            background: #ffc107;
            color: #856404;
        }
        .test-inputs button:hover {
            background: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📬 Contact Us</h1>
        <p class="subtitle">We'd love to hear from you!</p>

        <!-- Test buttons for trying XSS -->
        <div class="test-inputs">
            <h4>🧪 Test Security (try these inputs):</h4>
            <button type="button" onclick="fillXSS()">XSS Attack</button>
            <button type="button" onclick="fillHTML()">HTML Injection</button>
            <button type="button" onclick="fillValid()">Valid Data</button>
        </div>

        <?php if ($success): ?>
            <!-- Success Message -->
            <div class="alert alert-success">
                <strong>✅ Thank you!</strong> Your message has been received.
            </div>

            <!-- Display Submitted Data Safely -->
            <div class="submitted-data">
                <h3>📋 Submitted Information</h3>
                <table>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo e($submittedData['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo e($submittedData['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Subject:</th>
                        <td><?php echo e($submittedData['subject']); ?></td>
                    </tr>
                    <tr>
                        <th>Message:</th>
                        <td><?php echo nl2br(e($submittedData['message'])); ?></td>
                    </tr>
                    <tr>
                        <th>Submitted:</th>
                        <td><?php echo e($submittedData['submitted_at']); ?></td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin-top: 20px;">
                <a href="<?php echo e($_SERVER['PHP_SELF']); ?>">← Send another message</a>
            </p>

        <?php else: ?>
            <!-- Show general error summary if there are errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <strong>⚠️ Please fix the following errors:</strong>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <form method="POST" action="" novalidate>
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">
                        Name <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?php echo e($name); ?>"
                        placeholder="Your full name"
                        class="<?php echo hasError('name', $errors) ? 'error' : ''; ?>"
                        maxlength="50"
                    >
                    <?php if (hasError('name', $errors)): ?>
                        <div class="error-message"><?php echo e(getError('name', $errors)); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">
                        Email <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo e($email); ?>"
                        placeholder="your.email@example.com"
                        class="<?php echo hasError('email', $errors) ? 'error' : ''; ?>"
                    >
                    <?php if (hasError('email', $errors)): ?>
                        <div class="error-message"><?php echo e(getError('email', $errors)); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Subject Field -->
                <div class="form-group">
                    <label for="subject">
                        Subject <span class="required">*</span>
                    </label>
                    <select
                        id="subject"
                        name="subject"
                        class="<?php echo hasError('subject', $errors) ? 'error' : ''; ?>"
                    >
                        <?php foreach ($subjectOptions as $value => $label): ?>
                            <option
                                value="<?php echo e($value); ?>"
                                <?php echo $subject === $value ? 'selected' : ''; ?>
                            >
                                <?php echo e($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (hasError('subject', $errors)): ?>
                        <div class="error-message"><?php echo e(getError('subject', $errors)); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Message Field -->
                <div class="form-group">
                    <label for="message">
                        Message <span class="required">*</span>
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        placeholder="Write your message here... (minimum 10 characters)"
                        class="<?php echo hasError('message', $errors) ? 'error' : ''; ?>"
                        maxlength="1000"
                    ><?php echo e($message); ?></textarea>
                    <div class="char-count">
                        <span id="charCount"><?php echo strlen($message); ?></span>/1000 characters
                    </div>
                    <?php if (hasError('message', $errors)): ?>
                        <div class="error-message"><?php echo e(getError('message', $errors)); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit">Send Message</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Character counter for message
        const messageField = document.getElementById('message');
        const charCount = document.getElementById('charCount');

        if (messageField && charCount) {
            messageField.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
        }

        // Test input functions
        function fillXSS() {
            document.getElementById('name').value = '<script>alert("XSS")<\/script>';
            document.getElementById('email').value = 'test@example.com';
            document.getElementById('subject').value = 'general';
            document.getElementById('message').value = '<img src=x onerror="alert(\'Hacked!\')"> Click me!';
            updateCharCount();
        }

        function fillHTML() {
            document.getElementById('name').value = '<b>Bold Name</b>';
            document.getElementById('email').value = 'hacker@evil.com';
            document.getElementById('subject').value = 'support';
            document.getElementById('message').value = '<h1>Big Header</h1><a href="http://evil.com">Click here!</a>';
            updateCharCount();
        }

        function fillValid() {
            document.getElementById('name').value = 'John Smith';
            document.getElementById('email').value = 'john.smith@example.com';
            document.getElementById('subject').value = 'general';
            document.getElementById('message').value = 'Hello! I have a question about your services. Could you please provide more information about pricing and availability? Thank you!';
            updateCharCount();
        }

        function updateCharCount() {
            if (charCount && messageField) {
                charCount.textContent = messageField.value.length;
            }
        }
    </script>
</body>
</html>
