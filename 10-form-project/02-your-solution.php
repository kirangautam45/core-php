<?php
/**
 * Day 10: Mini Project - Safe Contact Form
 * File 2: Your Solution Template
 *
 * Run in browser: http://localhost/02-your-solution.php
 *
 * INSTRUCTIONS:
 * Complete the TODOs below to create a working secure contact form.
 * Refer to 01-contact-form.php if you get stuck.
 */

// Initialize variables
$name = '';
$email = '';
$subject = '';
$message = '';
$errors = [];
$success = false;

// Subject options
$subjectOptions = [
    '' => '-- Select a subject --',
    'general' => 'General Inquiry',
    'support' => 'Technical Support',
    'feedback' => 'Feedback'
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ========================================
    // TODO 1: GET AND TRIM INPUT
    // ========================================
    // Get values from $_POST and trim whitespace
    // Use the null coalescing operator (??) for safety

    $name = '';    // TODO: Get and trim name from $_POST
    $email = '';   // TODO: Get and trim email from $_POST
    $subject = ''; // TODO: Get subject from $_POST
    $message = ''; // TODO: Get and trim message from $_POST

    // ========================================
    // TODO 2: VALIDATE NAME
    // ========================================
    // - Required (not empty)
    // - Minimum 2 characters
    // - Maximum 50 characters

    // Your validation code here...

    // ========================================
    // TODO 3: VALIDATE EMAIL
    // ========================================
    // - Required (not empty)
    // - Must be valid email format (use filter_var)

    // Your validation code here...

    // ========================================
    // TODO 4: VALIDATE SUBJECT
    // ========================================
    // - Required (not empty)
    // - Must be a valid option from $subjectOptions

    // Your validation code here...

    // ========================================
    // TODO 5: VALIDATE MESSAGE
    // ========================================
    // - Required (not empty)
    // - Minimum 10 characters
    // - Maximum 1000 characters

    // Your validation code here...

    // ========================================
    // TODO 6: CHECK IF VALID
    // ========================================
    // If no errors, set $success = true

    if (empty($errors)) {
        $success = true;
        // In a real app: save to database, send email, etc.
    }
}

/**
 * TODO 7: Create a helper function to safely output strings
 *
 * This function should:
 * - Use htmlspecialchars()
 * - Use ENT_QUOTES flag
 * - Use UTF-8 encoding
 */
function e($string) {
    // TODO: Return sanitized string
    return $string; // FIX THIS!
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error {
            border-color: red;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
        button {
            padding: 12px 30px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .success {
            background: #d4edda;
            padding: 20px;
            border-radius: 4px;
            color: #155724;
        }
        .submitted-data {
            background: #f8f9fa;
            padding: 20px;
            margin-top: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Contact Us</h1>

    <?php if ($success): ?>
        <div class="success">
            <h2>Thank you!</h2>
            <p>Your message has been received.</p>
        </div>

        <div class="submitted-data">
            <h3>You submitted:</h3>
            <!-- TODO 8: Display the submitted data SAFELY using your e() function -->
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Subject:</strong> <?php echo $subjectOptions[$subject] ?? ''; ?></p>
            <p><strong>Message:</strong><br><?php echo nl2br($message); ?></p>
        </div>

    <?php else: ?>
        <!-- TODO 9: Add novalidate to form to test PHP validation -->
        <form method="POST" action="">

            <div class="form-group">
                <label>Name *</label>
                <!-- TODO 10: Add value attribute with sanitized $name -->
                <!-- TODO 11: Add error class if name has error -->
                <input type="text" name="name" placeholder="Your name">
                <?php if (isset($errors['name'])): ?>
                    <div class="error-message"><?php echo e($errors['name']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <!-- TODO 12: Add value attribute with sanitized $email -->
                <input type="email" name="email" placeholder="your@email.com">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo e($errors['email']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Subject *</label>
                <select name="subject">
                    <?php foreach ($subjectOptions as $value => $label): ?>
                        <!-- TODO 13: Add 'selected' attribute if this option matches $subject -->
                        <option value="<?php echo e($value); ?>">
                            <?php echo e($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['subject'])): ?>
                    <div class="error-message"><?php echo e($errors['subject']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Message *</label>
                <!-- TODO 14: Add sanitized $message as textarea content -->
                <textarea name="message" rows="5" placeholder="Your message (min 10 characters)"></textarea>
                <?php if (isset($errors['message'])): ?>
                    <div class="error-message"><?php echo e($errors['message']); ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Send Message</button>
        </form>
    <?php endif; ?>


</body>
</html>
