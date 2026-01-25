<?php
/**
 * Day 10: Mini Project - Safe Contact Form
 * File 3: Complete Solution for the Template
 *
 * Run in browser: http://localhost/03-solution.php
 *
 * This is the completed version of 02-your-solution.php
 * with all TODOs filled in.
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
    // TODO 1: GET AND TRIM INPUT ✅
    // ========================================
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = $_POST['subject'] ?? '';
    $message = trim($_POST['message'] ?? '');

    // ========================================
    // TODO 2: VALIDATE NAME ✅
    // ========================================
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters';
    } elseif (strlen($name) > 50) {
        $errors['name'] = 'Name must be less than 50 characters';
    }

    // ========================================
    // TODO 3: VALIDATE EMAIL ✅
    // ========================================
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    // ========================================
    // TODO 4: VALIDATE SUBJECT ✅
    // ========================================
    if (empty($subject)) {
        $errors['subject'] = 'Please select a subject';
    } elseif (!array_key_exists($subject, $subjectOptions)) {
        $errors['subject'] = 'Invalid subject selected';
    }

    // ========================================
    // TODO 5: VALIDATE MESSAGE ✅
    // ========================================
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Message must be at least 10 characters';
    } elseif (strlen($message) > 1000) {
        $errors['message'] = 'Message must be less than 1000 characters';
    }

    // ========================================
    // TODO 6: CHECK IF VALID ✅
    // ========================================
    if (empty($errors)) {
        $success = true;
        // In a real app: save to database, send email, etc.
    }
}

/**
 * TODO 7: Helper function to safely output strings ✅
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Contact Form - Solution</title>
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
            <!-- TODO 8: Display the submitted data SAFELY ✅ -->
            <p><strong>Name:</strong> <?php echo e($name); ?></p>
            <p><strong>Email:</strong> <?php echo e($email); ?></p>
            <p><strong>Subject:</strong> <?php echo e($subjectOptions[$subject] ?? ''); ?></p>
            <p><strong>Message:</strong><br><?php echo nl2br(e($message)); ?></p>
        </div>

        <p><a href="<?php echo e($_SERVER['PHP_SELF']); ?>">Send another message</a></p>

    <?php else: ?>
        <!-- TODO 9: Add novalidate to form ✅ -->
        <form method="POST" action="" novalidate>

            <div class="form-group">
                <label>Name *</label>
                <!-- TODO 10 & 11: Add value and error class ✅ -->
                <input
                    type="text"
                    name="name"
                    placeholder="Your name"
                    value="<?php echo e($name); ?>"
                    class="<?php echo isset($errors['name']) ? 'error' : ''; ?>"
                >
                <?php if (isset($errors['name'])): ?>
                    <div class="error-message"><?php echo e($errors['name']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <!-- TODO 12: Add value attribute ✅ -->
                <input
                    type="email"
                    name="email"
                    placeholder="your@email.com"
                    value="<?php echo e($email); ?>"
                    class="<?php echo isset($errors['email']) ? 'error' : ''; ?>"
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo e($errors['email']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Subject *</label>
                <select name="subject" class="<?php echo isset($errors['subject']) ? 'error' : ''; ?>">
                    <?php foreach ($subjectOptions as $value => $label): ?>
                        <!-- TODO 13: Add selected attribute ✅ -->
                        <option
                            value="<?php echo e($value); ?>"
                            <?php echo $subject === $value ? 'selected' : ''; ?>
                        >
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
                <!-- TODO 14: Add sanitized message content ✅ -->
                <textarea
                    name="message"
                    rows="5"
                    placeholder="Your message (min 10 characters)"
                    class="<?php echo isset($errors['message']) ? 'error' : ''; ?>"
                ><?php echo e($message); ?></textarea>
                <?php if (isset($errors['message'])): ?>
                    <div class="error-message"><?php echo e($errors['message']); ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Send Message</button>
        </form>
    <?php endif; ?>

    <hr style="margin-top: 40px;">
  
</body>
</html>
