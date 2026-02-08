<?php
session_start();
require __DIR__ . '/db.php';
require_once __DIR__ . '/SupabaseStorage.php';

// If already logged in, redirect to profile
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

$error = '';


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm'] ?? '';

        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            $error = 'All fields are required!';
        } elseif ($password !== $confirm_password) {
            $error = 'Passwords do not match!';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } else {
            // Check if user exists (Postgres)
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->rowCount() > 0) {
                $error = 'Username or Email already exists!';
            } else {
                // Handle File Upload
                $profile_pic = null;
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

                    if (in_array($ext, $allowed)) {
                        $filename = $username . '_' . time() . '.' . $ext;
                        // Upload to Supabase Storage
                        $storage = new SupabaseStorage();
                        if ($storage->upload($_FILES['profile_pic']['tmp_name'], $filename)) {
                            $profile_pic = $filename;
                        } else {
                            $error = 'Failed to upload image to storage.';
                        }
                    } else {
                        $error = 'Invalid file type!';
                    }
                }

                if (!$error) {
                    // Insert User
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, profile_pic) VALUES (?, ?, ?, ?)");
                    
                    if ($stmt->execute([$username, $email, $hashed_password, $profile_pic])) {
                        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registration successful! Please login.'];
                        header('Location: login.php');
                        exit;
                    } else {
                        $error = 'Registration failed due to a database error.';
                    }
                }
            }
        }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        form > button[type="submit"].register-btn {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            opacity: 0.9;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Register</h1>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">


        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        
        <input type="password" name="password" id="password" placeholder="Password (min 6 chars)" value="<?= htmlspecialchars($password) ?>" required>

        <input type="password" name="confirm" id="confirm" placeholder="Confirm Password" value="<?= htmlspecialchars($confirm_password) ?>" required>

        <label>Profile Picture (optional):</label>
        <input type="file" name="profile_pic" accept="image/*">
        <button type="submit" class="register-btn">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
