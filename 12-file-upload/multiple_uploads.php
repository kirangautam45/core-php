<?php
$uploadDir = __DIR__ . '/uploads/';
$maxFileSize = 2 * 1024 * 1024;
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxFiles = 5;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$results = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {

    // Restructure $_FILES array
    $files = [];
    $fileCount = count($_FILES['images']['name']);

    for ($i = 0; $i < $fileCount; $i++) {
        // Skip empty slots
        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        $files[] = [
            'name'     => $_FILES['images']['name'][$i],
            'type'     => $_FILES['images']['type'][$i],
            'tmp_name' => $_FILES['images']['tmp_name'][$i],
            'error'    => $_FILES['images']['error'][$i],
            'size'     => $_FILES['images']['size'][$i],
        ];
    }

    // Limit number of files
    if (count($files) > $maxFiles) {
        $files = array_slice($files, 0, $maxFiles);
    }

    // Process each file
    foreach ($files as $index => $file) {
        $result = [
            'original' => $file['name'],
            'status'   => 'pending',
            'message'  => '',
            'path'     => '',
        ];

        // Validate
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $result['status'] = 'error';
            $result['message'] = 'Upload error';
        } elseif ($file['size'] > $maxFileSize) {
            $result['status'] = 'error';
            $result['message'] = 'File too large';
        } else {
            // Check MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);

            if (!in_array($mimeType, $allowedTypes)) {
                $result['status'] = 'error';
                $result['message'] = 'Invalid type: ' . $mimeType;
            } else {
                // Save file
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newName = 'gallery_' . uniqid() . '.' . strtolower($ext);
                $destination = $uploadDir . $newName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $result['status'] = 'success';
                    $result['message'] = 'Uploaded successfully';
                    $result['path'] = 'uploads/' . $newName;
                    $result['size'] = number_format($file['size'] / 1024, 1) . ' KB';
                } else {
                    $result['status'] = 'error';
                    $result['message'] = 'Failed to save';
                }
            }
        }

        $results[] = $result;
    }
}

// Get existing gallery images
$galleryImages = glob($uploadDir . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 12: Multiple File Uploads</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #f0f0f0;
        }
        h1 { color: #333; }
        .form-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="file"] {
            width: 100%;
            padding: 20px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            background: #fafafa;
            margin-bottom: 20px;
        }
        button {
            background: #9C27B0;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #7B1FA2; }

        /* Results Table */
        .results {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .results h2 {
            background: #333;
            color: white;
            margin: 0;
            padding: 15px 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th { background: #f5f5f5; }
        .status-success { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }

        /* Gallery */
        .gallery {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .gallery h2 { margin-top: 0; }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }
        .gallery-item {
            aspect-ratio: 1;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .gallery-item:hover img { transform: scale(1.1); }
        .empty-gallery {
            text-align: center;
            color: #666;
            padding: 40px;
        }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Multiple File Uploads</h1>

    <div class="form-box">
        <div class="info">
            <strong>Upload up to <?= $maxFiles ?> images at once</strong><br>
            Max size per file: <?= $maxFileSize / 1024 / 1024 ?>MB | Allowed: JPG, PNG, GIF, WebP
        </div>

        <form method="POST" enctype="multipart/form-data">
            <label for="images">Select multiple images:</label>
         
            <input type="file"
                   name="images[]"
                   id="images"
                   accept="image/*"
                   multiple
                   required>

            <button type="submit">Upload All</button>
        </form>
    </div>

    <?php if (!empty($results)): ?>
    <div class="results">
        <h2>Upload Results</h2>
        <table>
            <thead>
                <tr>
                    <th>Preview</th>
                    <th>Original Name</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                <tr>
                    <td>
                        <?php if ($result['path']): ?>
                            <img src="<?= htmlspecialchars($result['path']) ?>" class="thumb" alt="Thumbnail">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($result['original']) ?></td>
                    <td><?= $result['size'] ?? '-' ?></td>
                    <td class="status-<?= $result['status'] ?>">
                        <?= strtoupper($result['status']) ?>
                    </td>
                    <td><?= htmlspecialchars($result['message']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="gallery">
        <h2>Gallery (<?= count($galleryImages) ?> images)</h2>

        <?php if (empty($galleryImages)): ?>
            <div class="empty-gallery">
                No images uploaded yet. Upload some images to see them here!
            </div>
        <?php else: ?>
            <div class="gallery-grid">
                <?php foreach (array_reverse($galleryImages) as $img): ?>
                    <div class="gallery-item">
                        <img src="<?= htmlspecialchars('uploads/' . basename($img)) ?>"
                             alt="Gallery image"
                             loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
