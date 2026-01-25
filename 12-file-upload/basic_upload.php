<?php
/**
 * DAY 12 - Part 1: Basic File Upload
 * Time: 10 minutes
 *
 * Learning Goals:
 * - Understand HTML form requirements for uploads
 * - Access uploaded file data via $_FILES
 * - Move uploaded files to permanent location
 */

// Create uploads directory if it doesn't exist
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$message = '';
$uploadedFile = '';

// ============================================
// PROCESS UPLOAD
// ============================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if file was uploaded
    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {

        // Display $_FILES structure (for learning)
        echo "<!-- DEBUG: \$_FILES contents:\n";
        print_r($_FILES);
        echo "-->\n";

        // Get file info
        $tmpName = $_FILES['myfile']['tmp_name'];  // Temp location
        $origName = $_FILES['myfile']['name'];      // Original filename
        $fileSize = $_FILES['myfile']['size'];      // Size in bytes
        $fileType = $_FILES['myfile']['type'];      // MIME type

        // Generate unique filename to prevent overwrites
        $extension = pathinfo($origName, PATHINFO_EXTENSION);
        $newFilename = uniqid('file_') . '.' . $extension;
        $destination = $uploadDir . $newFilename;

        // Move from temp to permanent location
        if (move_uploaded_file($tmpName, $destination)) {
            $message = "Success! File uploaded as: $newFilename";
            $uploadedFile = 'uploads/' . $newFilename;

            // Show file details
            $message .= "<br>Original name: $origName";
            $message .= "<br>Size: " . number_format($fileSize / 1024, 2) . " KB";
            $message .= "<br>Type: $fileType";
        } else {
            $message = "Error: Failed to move uploaded file.";
        }

    } else {
        // Handle upload errors
        $errorCode = $_FILES['myfile']['error'] ?? UPLOAD_ERR_NO_FILE;
        $errors = [
            UPLOAD_ERR_INI_SIZE   => 'File exceeds server size limit',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds form size limit',
            UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE    => 'No file was selected',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temp folder (server issue)',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk',
        ];
        $message = "Error: " . ($errors[$errorCode] ?? 'Unknown error');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 12: Basic File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
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
            margin-bottom: 20px;
            padding: 10px;
            border: 2px dashed #ccc;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #45a049; }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .preview { margin-top: 20px; max-width: 300px; }
        .preview img { max-width: 100%; border-radius: 4px; }
        code {
            background: #e9e9e9;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .note {
            background: #fff3cd;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Basic File Upload</h1>

    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'Success') !== false ? 'success' : 'error' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if ($uploadedFile): ?>
        <div class="preview">
            <strong>Preview:</strong><br>
            <img src="<?= htmlspecialchars($uploadedFile) ?>" alt="Uploaded file">
        </div>
    <?php endif; ?>

    <div class="form-box">
        <!--
            IMPORTANT FORM REQUIREMENTS:
            1. method="POST" - Files can't be sent via GET
            2. enctype="multipart/form-data" - Required for files!
        -->
        <form method="POST" enctype="multipart/form-data">
            <label for="myfile">Select a file to upload:</label>
            <input type="file" name="myfile" id="myfile" required>

            <button type="submit">Upload File</button>
        </form>
    </div>
</body>
</html>
