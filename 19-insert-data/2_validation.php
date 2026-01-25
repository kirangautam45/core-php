<?php
/**
 * Day 19: Form Validation
 * Server-side validation before database insert
 */

require 'db_config.php';

$errors = [];
$success = false;
$name = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate name
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate message
    if (empty($message)) {
        $errors['message'] = "Message is required";
    }

    // Save to database if no errors
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        $success = true;
        $name = $email = $message = ''; // Clear form
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Validation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <h1>Contact Form with Validation</h1>

    <?php if ($success): ?>
        <div class="success">Message saved successfully!</div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Name <span class="required">*</span></label>
            <input type="text" name="name"
                   value="<?= htmlspecialchars($name) ?>"
                   class="<?= isset($errors['name']) ? 'input-error' : '' ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error-msg"><?= $errors['name'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($email) ?>"
                   class="<?= isset($errors['email']) ? 'input-error' : '' ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error-msg"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Message <span class="required">*</span></label>
            <textarea name="message" rows="4"
                      class="<?= isset($errors['message']) ? 'input-error' : '' ?>"><?= htmlspecialchars($message) ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="error-msg"><?= $errors['message'] ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-success">Send Message</button>
    </form>
    </div>
</body>
</html>
