<?php
session_start();
require __DIR__ . '/db.php';
// SupabaseStorage is autoloaded via composer or needs to be included if not. 
// Assuming it's in the root or autoloaded. Based on register.php usage, let's include it if class not exists, just to be safe, or assume autoload.
// However, register.php didn't explicit include, but db.php requires vendor/autoload. If SupabaseStorage is not in namespace/composer, we might need to require it.
// Checking file listing, SupabaseStorage.php is in root. Composer autoload usually maps src. 
// Let's add require just in case, similar to how we might need it if not autoloaded.
require_once __DIR__ . '/SupabaseStorage.php';

// Check if logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['user'];

// Fetch user data from DB
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    // Should not happen if logged in, but handle safety
    session_destroy();
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

// Handle profile info update (email and username)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $newEmail = trim($_POST['email'] ?? '');
    $newUsername = trim($_POST['new_username'] ?? '');

    if (empty($newEmail) || empty($newUsername)) {
        $error = 'Email and username are required.';
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $newUsername)) {
        $error = 'Username can only contain letters, numbers, and underscores.';
    } else {
        // Check availability if changed
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $checkStmt->execute([$newUsername, $newEmail, $user['id']]);
        
        if ($checkStmt->rowCount() > 0) {
            $error = 'Username or Email already taken.';
        } else {
            // Update DB
            $updateStmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            if ($updateStmt->execute([$newUsername, $newEmail, $user['id']])) {
                // Update session if username changed
                if ($newUsername !== $username) {
                    $_SESSION['user'] = $newUsername;
                    $username = $newUsername;
                }
                
                // Refresh $user data
                $user['username'] = $newUsername;
                $user['email'] = $newEmail;
                
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Profile updated successfully!'];
                header('Location: profile.php');
                exit;
            } else {
                $error = 'Failed to update profile.';
            }
        }
    }
}

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            $error = 'Only JPG, PNG, GIF allowed!';
        } elseif ($_FILES['profile_pic']['size'] > 5242880) { // 5MB limit
            $error = 'File too large! Max 5MB.';
        } else {
            $filename = $username . '_' . time() . '.' . $extension;
            
            // Upload to Supabase Storage
            $storage = new SupabaseStorage();
            if ($storage->upload($_FILES['profile_pic']['tmp_name'], $filename)) {
                
                // Update DB with new filename
                $picStmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
                if ($picStmt->execute([$filename, $user['id']])) {
                    $user['profile_pic'] = $filename;
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Profile picture updated successfully!'];
                    header('Location: profile.php');
                    exit;
                } else {
                    $error = 'Database update failed.';
                }
            } else {
                $error = 'Failed to upload image to Supabase Storage.';
            }
        }
    } else {
        $error = 'Upload error code: ' . $_FILES['profile_pic']['error'];
    }
}

// Get flash message
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - <?= htmlspecialchars($username) ?></title>
    <style>
        body {
            font-family: Arial;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }
        .profile-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }
        .no-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary { background: #007bff; }
        .btn-primary:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .info {
            margin: 20px 0;
            color: #666;
        }
        .info p {
            margin: 8px 0;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .upload-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .upload-form input[type="file"] {
            margin: 10px 0;
        }
        .upload-form h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .actions {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <h1>My Profile</h1>

        <?php if ($flash): ?>
            <div class="<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($user['profile_pic'])): 
            $storage = new SupabaseStorage();
            $picUrl = $storage->getUrl($user['profile_pic']);
        ?>
            <img src="<?= htmlspecialchars($picUrl) ?>" class="profile-pic" alt="Profile Picture">
        <?php else: ?>
            <div class="no-pic">No Photo</div>
        <?php endif; ?>

        <h2><?= htmlspecialchars($username) ?></h2>

        <div class="info">
            <?php if (!empty($user['email'])): ?>
                <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <?php endif; ?>
            <p>Member since: <?= htmlspecialchars($user['created_at']) ?></p>
        </div>

        <form method="POST" class="upload-form">
            <h3>Edit Profile</h3>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="new_username" value="<?= htmlspecialchars($username) ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            </div>
            <button type="submit" name="update_info" class="btn btn-primary">Save Changes</button>
        </form>

        <form method="POST" enctype="multipart/form-data" class="upload-form">
            <h3>Profile Picture</h3>
            <input type="file" name="profile_pic" accept="image/*" required>
            <br>
            <small class="text-muted">Max upload size: <?= ini_get('upload_max_filesize') ?></small>
            <br>
            <button type="submit" class="btn btn-secondary">Upload New Picture</button>
        </form>

        <div class="actions">
            <a href="change-password.php" class="btn btn-primary">Change Password</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
