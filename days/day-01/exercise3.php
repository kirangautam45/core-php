<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 3 - Comment Practice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 40px 20px;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            flex: 1;
        }
        h1 {
            color: #11998e;
            font-size: 2.5rem;
            margin-bottom: 25px;
            border-bottom: 3px solid #11998e;
            padding-bottom: 10px;
        }
        p {
            color: #555;
            font-size: 1.1rem;
            line-height: 1.8;
            padding: 15px 20px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-left: 4px solid #11998e;
            border-radius: 0 8px 8px 0;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        p:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(17, 153, 142, 0.3);
        }
        nav {
            max-width: 700px;
            margin: 20px auto 0;
            padding: 20px;
            background: white;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        nav a {
            color: #11998e;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 600;
            transition: color 0.2s;
        }
        nav a:hover {
            color: #38ef7d;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            // This is a single-line comment using double slashes
            # This is also a single-line comment using hash

            /*
                This is a multi-line comment.
                It can span multiple lines.
                Useful for longer explanations.
            */

            // Output a heading - this displays the main title
            echo "<h1>Comment Practice</h1>";

            // Output a paragraph - demonstrates basic echo usage
            echo "<p>This line demonstrates the echo statement.</p>";

            // Output another paragraph - shows string concatenation
            echo "<p>PHP " . "strings " . "can be concatenated with dots.</p>";

            // Using print instead of echo - works similarly
            print "<p>This line uses print instead of echo.</p>";
        ?>
    </div>

    <nav>
        <a href="index.php">Home</a>
        <a href="exercise1.php">Exercise 1</a>
        <a href="exercise2.php">Exercise 2</a>
        <a href="exercise3.php">Exercise 3</a>
    </nav>
</body>
</html>
