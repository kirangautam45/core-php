<?php
/**
 * Day 8: Forms in PHP
 * File 3: Different Form Input Types
 *
 * Run in browser: http://localhost/03-form-inputs.php
 */

$submitted = false;
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $formData = $_POST;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Types</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 30px auto; padding: 20px; }
        .form-section { background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .form-section h3 { margin-top: 0; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"],
        input[type="number"], input[type="date"], input[type="url"],
        input[type="tel"], input[type="color"], select, textarea {
            width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ddd;
            border-radius: 4px; box-sizing: border-box;
        }
        .radio-group, .checkbox-group { display: flex; gap: 20px; flex-wrap: wrap; }
        .radio-group label, .checkbox-group label { font-weight: normal; display: flex; align-items: center; gap: 5px; }
        .radio-group input, .checkbox-group input { width: auto; }
        button { padding: 12px 30px; background: #007bff; color: white; border: none;
                cursor: pointer; font-size: 16px; border-radius: 4px; margin-top: 20px; }
        button:hover { background: #0056b3; }
        .results { background: #e7f3ff; padding: 20px; border-radius: 8px; margin-top: 30px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .inline-group { display: flex; gap: 10px; }
        .inline-group > div { flex: 1; }
    </style>
</head>
<body>
    <h1>📋 Form Input Types</h1>
    <p>This example demonstrates different HTML form inputs and how to process them in PHP.</p>

    <form method="POST" action="">
        <!-- Text Inputs -->
        <div class="form-section">
            <h3>Text Inputs</h3>

            <div class="form-group">
                <label>Text Input:</label>
                <input type="text" name="text_input" placeholder="Enter text" value="<?php echo htmlspecialchars($formData['text_input'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Email Input:</label>
                <input type="email" name="email_input" placeholder="email@example.com" value="<?php echo htmlspecialchars($formData['email_input'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Password Input:</label>
                <input type="password" name="password_input" placeholder="Enter password">
            </div>

            <div class="form-group">
                <label>Textarea:</label>
                <textarea name="textarea_input" rows="3" placeholder="Enter multiple lines..."><?php echo htmlspecialchars($formData['textarea_input'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Hidden Input (value="secret123"):</label>
                <input type="hidden" name="hidden_input" value="secret123">
                <small>Hidden fields are not visible but sent with form</small>
            </div>
        </div>

        <!-- Number & Date Inputs -->
        <div class="form-section">
            <h3>Number & Date Inputs</h3>

            <div class="inline-group">
                <div class="form-group">
                    <label>Number (1-100):</label>
                    <input type="number" name="number_input" min="1" max="100" value="<?php echo htmlspecialchars($formData['number_input'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Range (0-100):</label>
                    <input type="range" name="range_input" min="0" max="100" value="<?php echo htmlspecialchars($formData['range_input'] ?? '50'); ?>">
                </div>
            </div>

            <div class="inline-group">
                <div class="form-group">
                    <label>Date:</label>
                    <input type="date" name="date_input" value="<?php echo htmlspecialchars($formData['date_input'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Color:</label>
                    <input type="color" name="color_input" value="<?php echo htmlspecialchars($formData['color_input'] ?? '#007bff'); ?>">
                </div>
            </div>
        </div>

        <!-- Selection Inputs -->
        <div class="form-section">
            <h3>Selection Inputs</h3>

            <div class="form-group">
                <label>Select Dropdown:</label>
                <select name="select_input">
                    <option value="">-- Select an option --</option>
                    <option value="option1" <?php echo ($formData['select_input'] ?? '') === 'option1' ? 'selected' : ''; ?>>Option 1</option>
                    <option value="option2" <?php echo ($formData['select_input'] ?? '') === 'option2' ? 'selected' : ''; ?>>Option 2</option>
                    <option value="option3" <?php echo ($formData['select_input'] ?? '') === 'option3' ? 'selected' : ''; ?>>Option 3</option>
                </select>
            </div>

            <div class="form-group">
                <label>Radio Buttons (single choice):</label>
                <div class="radio-group">
                    <label><input type="radio" name="radio_input" value="small" <?php echo ($formData['radio_input'] ?? '') === 'small' ? 'checked' : ''; ?>> Small</label>
                    <label><input type="radio" name="radio_input" value="medium" <?php echo ($formData['radio_input'] ?? '') === 'medium' ? 'checked' : ''; ?>> Medium</label>
                    <label><input type="radio" name="radio_input" value="large" <?php echo ($formData['radio_input'] ?? '') === 'large' ? 'checked' : ''; ?>> Large</label>
                </div>
            </div>

            <div class="form-group">
                <label>Checkboxes (multiple choice) - Note the [] in name:</label>
                <div class="checkbox-group">
                    <?php $selectedColors = $formData['checkbox_input'] ?? []; ?>
                    <label><input type="checkbox" name="checkbox_input[]" value="red" <?php echo in_array('red', $selectedColors) ? 'checked' : ''; ?>> Red</label>
                    <label><input type="checkbox" name="checkbox_input[]" value="green" <?php echo in_array('green', $selectedColors) ? 'checked' : ''; ?>> Green</label>
                    <label><input type="checkbox" name="checkbox_input[]" value="blue" <?php echo in_array('blue', $selectedColors) ? 'checked' : ''; ?>> Blue</label>
                    <label><input type="checkbox" name="checkbox_input[]" value="yellow" <?php echo in_array('yellow', $selectedColors) ? 'checked' : ''; ?>> Yellow</label>
                </div>
            </div>

            <div class="form-group">
                <label>Single Checkbox (agree to terms):</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="agree" value="yes" <?php echo isset($formData['agree']) ? 'checked' : ''; ?>> I agree to the terms</label>
                </div>
            </div>
        </div>

        <button type="submit">Submit Form</button>
    </form>

    <?php if ($submitted): ?>
        <div class="results">
            <h2>📊 Submitted Data ($_POST)</h2>
            <pre><?php
                $displayData = $formData;
                // Hide password for display
                if (isset($displayData['password_input'])) {
                    $displayData['password_input'] = '******** (hidden)';
                }
                print_r($displayData);
            ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>
