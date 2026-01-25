<?php
// Handle POST login
$loginMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // htmlspecialchars() converts special characters to HTML entities
    // Example: <script> becomes &lt;script&gt;
    // This prevents XSS (Cross-Site Scripting) attacks
    $username = htmlspecialchars($_POST['username'] ?? '');
    if (!empty($username)) {
        $loginMessage = "Welcome, $username!";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Day 08: Forms in PHP</title>
    <style>
        body { font-family: Arial, sans-serif; 
        max-width: 600px; margin: 50px auto; padding: 20px; }
        .box { background: #f5f5f5; padding: 20px; border-radius: 8px;
         margin-bottom: 30px; }
        input[type="text"], input[type="password"] 
        { padding: 10px; font-size: 16px; width: 200px; }
        button { padding: 10px 20px; background: #007bff;
         color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { background: #d4edda; color: #155724;
         padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .url { background: #fff3cd; padding: 10px; 
        border-radius: 4px; font-family: monospace; margin: 10px 0; }
        code { background: #e9ecef; padding: 2px 6px;
         border-radius: 3px; }
        pre { background: #2d3436; color: #dfe6e9; 
        padding: 15px; border-radius: 6px; overflow-x: auto; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 10px; }
    </style>
</head>
<body>

<h1>Day 08: Forms in PHP</h1>
<!-- ========== POST EXAMPLE ========== -->
<div class="box">
    <h2>POST Method - Login</h2>
    <?php if ($loginMessage): ?>
        <div class="success"><?php echo $loginMessage; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username"><br><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <button type="submit">Login</button>
    </form>
</div>


<?php
// Handle GET search
$searchResult = '';
if (isset($_GET['q'])) {
    $searchResult = htmlspecialchars($_GET['q']);
}
?>
<!-- ========== GET EXAMPLE ========== -->
<div class="box">
    <h2>GET Method - Search</h2>

    <form method="GET">
        <input type="text" name="q" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    <?php if ($searchResult): ?>
        <div class="url">URL: <?php echo $_SERVER['REQUEST_URI']; ?></div>
        <p>You searched for: <strong><?php echo $searchResult; ?></strong></p>
    <?php endif; ?>
</div>
</body>
</html>
