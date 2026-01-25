<?php
/**
 * Day 9: Form Validation & Sanitization
 * File 2: Sanitization Examples
 *
 * Run in browser: http://localhost/02-sanitization.php
 */

$examples = [];
$userInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = $_POST['user_input'] ?? '';

    // ==========================
    // SANITIZATION EXAMPLES
    // ==========================

    // 1. htmlspecialchars - Converts special characters to HTML entities
    $examples['htmlspecialchars'] = [
        'function' => 'htmlspecialchars($input, ENT_QUOTES, "UTF-8")',
        'result' => htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8'),
        'description' => 'Converts <, >, &, ", \' to HTML entities. Prevents XSS attacks.',
        'use_for' => 'Displaying user input in HTML'
    ];

    // 2. strip_tags - Removes HTML and PHP tags
    $examples['strip_tags'] = [
        'function' => 'strip_tags($input)',
        'result' => strip_tags($userInput),
        'description' => 'Removes all HTML and PHP tags from string.',
        'use_for' => 'Plain text output, removing formatting'
    ];

    // 3. strip_tags with allowed tags
    $examples['strip_tags_allowed'] = [
        'function' => 'strip_tags($input, "<b><i><u>")',
        'result' => strip_tags($userInput, '<b><i><u>'),
        'description' => 'Removes tags except specified ones.',
        'use_for' => 'Allowing basic formatting only'
    ];

    // 4. trim - Remove whitespace
    $examples['trim'] = [
        'function' => 'trim($input)',
        'result' => '"' . trim($userInput) . '"',
        'description' => 'Removes whitespace from beginning and end.',
        'use_for' => 'Cleaning user input'
    ];

    // 5. FILTER_SANITIZE_EMAIL
    $examples['sanitize_email'] = [
        'function' => 'filter_var($input, FILTER_SANITIZE_EMAIL)',
        'result' => filter_var($userInput, FILTER_SANITIZE_EMAIL),
        'description' => 'Removes all characters except letters, digits, and !#$%&\'*+-=?^_`{|}~@.[]',
        'use_for' => 'Cleaning email addresses'
    ];

    // 6. FILTER_SANITIZE_URL
    $examples['sanitize_url'] = [
        'function' => 'filter_var($input, FILTER_SANITIZE_URL)',
        'result' => filter_var($userInput, FILTER_SANITIZE_URL),
        'description' => 'Removes all characters except letters, digits, and $-_.+!*\'(),{}|\\\\^~[]`<>#%";/?:@&=',
        'use_for' => 'Cleaning URLs'
    ];

    // 7. FILTER_SANITIZE_NUMBER_INT
    $examples['sanitize_int'] = [
        'function' => 'filter_var($input, FILTER_SANITIZE_NUMBER_INT)',
        'result' => filter_var($userInput, FILTER_SANITIZE_NUMBER_INT),
        'description' => 'Removes all characters except digits and + -',
        'use_for' => 'Extracting integers from strings'
    ];

    // 8. FILTER_SANITIZE_NUMBER_FLOAT
    $examples['sanitize_float'] = [
        'function' => 'filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)',
        'result' => filter_var($userInput, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        'description' => 'Removes all characters except digits, +, -, and optionally ., ,',
        'use_for' => 'Extracting decimals from strings'
    ];

    // 9. preg_replace - Remove non-alphanumeric
    $examples['alphanumeric_only'] = [
        'function' => 'preg_replace("/[^a-zA-Z0-9]/", "", $input)',
        'result' => preg_replace('/[^a-zA-Z0-9]/', '', $userInput),
        'description' => 'Keeps only letters and numbers.',
        'use_for' => 'Usernames, slugs, codes'
    ];

    // 10. preg_replace - Normalize whitespace
    $examples['normalize_space'] = [
        'function' => 'preg_replace("/\\s+/", " ", trim($input))',
        'result' => preg_replace('/\s+/', ' ', trim($userInput)),
        'description' => 'Replaces multiple spaces with single space.',
        'use_for' => 'Cleaning text input'
    ];

    // 11. addslashes (for legacy - use prepared statements instead)
    $examples['addslashes'] = [
        'function' => 'addslashes($input)',
        'result' => addslashes($userInput),
        'description' => 'Escapes quotes and backslashes. NOT for SQL - use prepared statements!',
        'use_for' => 'Legacy code only (avoid for new projects)'
    ];

    // 12. nl2br - Convert newlines to <br>
    $examples['nl2br'] = [
        'function' => 'nl2br(htmlspecialchars($input))',
        'result' => nl2br(htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8')),
        'description' => 'Converts newlines to HTML line breaks (with XSS protection).',
        'use_for' => 'Displaying multiline text in HTML'
    ];
}

// Custom sanitization function
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
            return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        case 'html':
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        case 'alphanumeric':
            return preg_replace('/[^a-zA-Z0-9]/', '', $input);
        case 'string':
        default:
            return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanitization Examples</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 30px auto; padding: 20px; }
        .input-section { background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        textarea { width: 100%; height: 100px; font-size: 14px; padding: 10px; font-family: monospace; }
        button { padding: 12px 30px; background: #007bff; color: white; border: none;
                cursor: pointer; font-size: 16px; border-radius: 4px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: top; }
        th { background: #f8f9fa; }
        code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; font-size: 12px; }
        .result { background: #d4edda; padding: 8px; border-radius: 4px; word-break: break-all; }
        .warning { background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .presets { margin: 15px 0; }
        .presets button { padding: 8px 15px; margin: 5px; font-size: 14px; background: #6c757d; }
        .presets button:hover { background: #5a6268; }
    </style>
</head>
<body>
    <h1>🧹 Sanitization Examples</h1>

    <div class="warning">
        <strong>⚠️ Important:</strong> Always sanitize user input before displaying or storing it.
        Sanitization removes/escapes potentially dangerous characters.
    </div>

    <div class="input-section">
        <h3>Enter test input:</h3>
        <form method="POST">
            <textarea name="user_input" placeholder="Try entering HTML, scripts, special characters..."><?php echo htmlspecialchars($userInput); ?></textarea>

            <div class="presets">
                <strong>Quick test inputs:</strong><br>
                <button type="button" onclick="setInput('<script>alert(\"XSS\")</script>')">XSS Attack</button>
                <button type="button" onclick="setInput('<b>Bold</b> and <script>bad</script>')">Mixed HTML</button>
                <button type="button" onclick="setInput('  lots   of   spaces  ')">Extra Spaces</button>
                <button type="button" onclick="setInput('email@test<script>.com')">Malformed Email</button>
                <button type="button" onclick="setInput('Price: $1,234.56')">Number with symbols</button>
                <button type="button" onclick="setInput('Line 1\nLine 2\nLine 3')">Multi-line</button>
            </div>

            <button type="submit">Test Sanitization</button>
        </form>
    </div>

    <?php if (!empty($examples)): ?>
        <h2>Results for: <code><?php echo htmlspecialchars($userInput); ?></code></h2>

        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Function</th>
                    <th style="width: 30%;">Code</th>
                    <th style="width: 25%;">Result</th>
                    <th style="width: 30%;">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examples as $name => $example): ?>
                    <tr>
                        <td><strong><?php echo $name; ?></strong></td>
                        <td><code><?php echo htmlspecialchars($example['function']); ?></code></td>
                        <td>
                            <div class="result"><?php echo htmlspecialchars($example['result']); ?></div>
                        </td>
                        <td>
                            <?php echo $example['description']; ?><br>
                            <small><strong>Use for:</strong> <?php echo $example['use_for']; ?></small>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <hr style="margin: 40px 0;">

    <h2>Custom Sanitize Function</h2>
    <pre style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
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
            return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        case 'html':
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        case 'alphanumeric':
            return preg_replace('/[^a-zA-Z0-9]/', '', $input);
        case 'string':
        default:
            return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}

// Usage:
$name = sanitize($_POST['name']);
$email = sanitize($_POST['email'], 'email');
$age = sanitize($_POST['age'], 'int');
    </pre>

    <script>
        function setInput(value) {
            document.querySelector('textarea').value = value;
        }
    </script>
</body>
</html>
