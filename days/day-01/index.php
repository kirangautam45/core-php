<!DOCTYPE html> 
<html> 
    <head>
        <title>My First PHP Page</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: #f5f5f5;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                color: #333;
            }
            nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 15px;
                background: #fff;
                text-align: center;
                border-top: 1px solid #ddd;
            }
            nav a {
                color: #4F5B93;
                text-decoration: none;
                margin: 0 15px;
            }
            nav a:hover {
                text-decoration: underline;
            }
            h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: #4F5B93;
            }
            h2 {
                font-size: 1.25rem;
                margin-top: 0.5rem;
                color: #666;
            }
        </style>
    </head> 
     <body> 
        <h1>Hello from HTML!</h1>
         <?php echo "<h2>Hello from PHP! with echo</h2>"; ?> 
         <?php print "<h2>Hello from PHP! with print</h2>"; ?> 
        <nav>
            <a href="index.php">Home</a>
            <a href="exercise1.php">Exercise 1</a>
            <a href="exercise2.php">Exercise 2</a>
            <a href="exercise3.php">Exercise 3</a>
        </nav>
        </body>
        </html>