<?php
    // Exercise 1: Basic Output
    // Display personal info using echo statements

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Exercise 1 - Basic Output</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: #f5f5f5;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 40px 20px 80px;
            }
            .container {
                max-width: 600px;
                width: 100%;
                background: white;
                padding: 30px;
            }
            h1 {
                color: #4F5B93;
                font-size: 2rem;
                margin-bottom: 15px;
                border-bottom: 3px solid #4F5B93;
                padding-bottom: 10px;
            }
            p {
                color: #555;
                font-size: 1.1rem;
                line-height: 1.6;
                margin-bottom: 20px;
            }
            h3 {
                color: #444;
                font-size: 1.2rem;
                margin-bottom: 15px;
            }
            ul {
                list-style: none;
            }
            li {
                padding: 10px 15px;
                margin-bottom: 8px;
                background: #f8f9fa;
                border-left: 4px solid #4F5B93;
                color: #555;
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
        </style>
    </head>
    <body>";

    echo "<div class='container'>";
    echo "<h1>Kiran</h1>";
    echo "<p>My favorite hobby is coding and building projects.</p>";

    echo "<h3>Three things I want to learn:</h3>";
    echo "<ul>";
    echo "<li>PHP and web development</li>";
    echo "<li>Database management with MySQL</li>";
    echo "<li>Building full-stack applications</li>";
    echo "</ul>";
    echo "</div>";

    echo "<nav>";
    echo "<a href='index.php'>Home</a>";
    echo "<a href='exercise1.php'>Exercise 1</a>";
    echo "<a href='exercise2.php'>Exercise 2</a>";
    echo "<a href='exercise3.php'>Exercise 3</a>";
    echo "</nav>";

    echo "</body></html>";
?>
