<?php

// Configuration
$uploadDir = __DIR__ . '/uploads/';
$maxFileSize = 2 * 1024 * 1024;  // 2MB in bytes
$maxWidth = 2000;
$maxHeight = 2000;
$allowedTypes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif',
    'image/webp' => 'webp',
];

// Create uploads directory
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$errors = [];
$success = '';
$uploadedFile = '';

// ============================================
// PROCESS UPLOAD WITH VALIDATION
// ============================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if file was selected
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Please select a file to upload.";
    } else {
        $file = $_FILES['image'];

        // Step 1: Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Upload error occurred (code: {$file['error']})";
        }

        // Step 2: Validate file size
        if ($file['size'] > $maxFileSize) {
            $sizeMB = number_format($file['size'] / 1024 / 1024, 2);
            $limitMB = $maxFileSize / 1024 / 1024;
            $errors[] = "File too large ({$sizeMB}MB). Maximum: {$limitMB}MB";
        }

        // Step 3: Validate MIME type using finfo (SECURE method)
        // DON'T trust $_FILES['type'] - it can be faked!
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedType = finfo_file($finfo, $file['tmp_name']);

        if (!array_key_exists($detectedType, $allowedTypes)) {
            $errors[] = "Invalid file type: $detectedType. Allowed: JPG, PNG, GIF, WebP";
        }

        // Step 4: Validate image dimensions (if it's an image)
        if (empty($errors)) {
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo === false) {
                $errors[] = "File is not a valid image.";
            } else {
                $width = $imageInfo[0];
                $height = $imageInfo[1];

                if ($width > $maxWidth || $height > $maxHeight) {
                    $errors[] = "Image dimensions too large ({$width}x{$height}). Max: {$maxWidth}x{$maxHeight}";
                }
            }
        }

        // Step 5: Security check - look for PHP code in file
        if (empty($errors)) {
            $content = file_get_contents($file['tmp_name']);
            $suspicious = ['<?php', '<?=', '<script', 'eval(', 'base64_decode'];
            foreach ($suspicious as $pattern) {
                if (stripos($content, $pattern) !== false) {
                    $errors[] = "File contains suspicious content.";
                    break;
                }
            }
        }

        // Step 6: Move file if all validations pass
        if (empty($errors)) {
            // Generate safe filename
            $extension = $allowedTypes[$detectedType];
            $newFilename = 'img_' . uniqid() . '.' . $extension;
            $destination = $uploadDir . $newFilename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $success = "Image uploaded successfully!";
                $uploadedFile = 'uploads/' . $newFilename;

                // Get final image info
                $finalInfo = getimagesize($destination);
                $success .= "<br>Dimensions: {$finalInfo[0]}x{$finalInfo[1]}";
                $success .= "<br>Size: " . number_format($file['size'] / 1024, 1) . " KB";
            } else {
                $errors[] = "Failed to save file.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 12: Secure Image Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-box {
            background: #f5f5f5;
            padding: 30px;
            border-radius: 8px;
        }
        h1 { color: #333; }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="file"] {
            margin-bottom: 15px;
            padding: 15px;
            border: 2px dashed #ccc;
            width: 100%;
            box-sizing: border-box;
            background: white;
        }
        button {
            background: #2196F3;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #1976D2; }
        .errors {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .errors ul { margin: 0; padding-left: 20px; }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .preview {
            margin-top: 20px;
            text-align: center;
        }
        .preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .limits {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .limits h3 { margin-top: 0; }
        .security-note {
            background: #fff3cd;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        code {
            background: #e9e9e9;
            padding: 2px 6px;
            border-radius: 3px;
        }
        #preview-container { display: none; margin-top: 15px; }
        #preview-img { max-width: 200px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Secure Image Upload</h1>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <strong>Upload failed:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
        <div class="preview">
            <img src="<?= htmlspecialchars($uploadedFile) ?>" alt="Uploaded image">
        </div>
    <?php endif; ?>

    <div class="limits">
        <h3>Upload Limits</h3>
        <ul>
            <li>Max file size: <?= $maxFileSize / 1024 / 1024 ?>MB</li>
            <li>Max dimensions: <?= $maxWidth ?>x<?= $maxHeight ?> pixels</li>
            <li>Allowed types: JPG, PNG, GIF, WebP</li>
        </ul>
    </div>

    <div class="form-box">
        <form method="POST" enctype="multipart/form-data">
            <!-- Hidden max size (browser hint, not enforced) -->
            <input type="hidden" name="MAX_FILE_SIZE" value="<?= $maxFileSize ?>">

            <label for="image">Select an image:</label>
            <input type="file"
                   name="image"
                   id="image"
                   accept="image/jpeg,image/png,image/gif,image/webp"
                   onchange="previewImage(this)">

            <div id="preview-container">
                <strong>Preview:</strong><br>
                <img id="preview-img" src="" alt="Preview">
            </div>

            <br>
            <button type="submit">Upload Image</button>
        </form>
    </div>

    <div class="security-note">
        <strong>Security Validations:</strong>
        <ol>
            <li><strong>MIME type</strong> - Use <code>finfo_file()</code>, NOT <code>$_FILES['type']</code></li>
            <li><strong>File size</strong> - Check against limit</li>
            <li><strong>Image validation</strong> - Use <code>getimagesize()</code></li>
            <li><strong>Content scan</strong> - Check for suspicious code</li>
            <li><strong>Unique filename</strong> - Never use original filename</li>
        </ol>
    </div>

    <script>
        function previewImage(input) {
            const container = document.getElementById('preview-container');
            const img = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
