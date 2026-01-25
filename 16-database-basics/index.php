<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 16: Introduction to Databases</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            color: #1e3c72;
            margin-bottom: 15px;
            border-bottom: 3px solid #2a5298;
            padding-bottom: 10px;
        }

        .card h3 {
            color: #2a5298;
            margin: 20px 0 10px;
        }

        .card p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .card ul {
            margin-left: 20px;
            color: #555;
            line-height: 2;
        }

        .code-block {
            background: #1e1e1e;
            color: #9cdcfe;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            margin: 15px 0;
        }

        .code-block .keyword {
            color: #569cd6;
        }

        .code-block .string {
            color: #ce9178;
        }

        .code-block .comment {
            color: #6a9955;
        }

        .code-block .function {
            color: #dcdcaa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #1e3c72;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #e9ecef;
        }

        .highlight {
            background: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            border-radius: 5px;
            margin: 15px 0;
        }

        .success {
            background: #d4edda;
            border-left-color: #28a745;
        }

        .info {
            background: #d1ecf1;
            border-left-color: #17a2b8;
        }

        .diagram {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 15px 0;
        }

        .diagram-box {
            display: inline-block;
            background: #1e3c72;
            color: #fff;
            padding: 15px 25px;
            border-radius: 8px;
            margin: 5px;
        }

        .diagram-arrow {
            display: inline-block;
            font-size: 24px;
            color: #1e3c72;
            margin: 0 10px;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #fff;
            color: #1e3c72;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #1e3c72;
            color: #fff;
        }

        .data-type-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }

        .data-type-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #1e3c72;
        }

        .data-type-card code {
            background: #1e3c72;
            color: #fff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Day 16: Introduction to Databases</h1>

        <!-- What is a Database -->
        <div class="card">
            <h2>What is a Database?</h2>
            <p>A <strong>database</strong> is an organized collection of structured data stored electronically. Think of it as a digital filing cabinet where you can store, organize, and retrieve information efficiently.</p>

            <h3>Why Use a Database?</h3>
            <ul>
                <li><strong>Store</strong> large amounts of data efficiently</li>
                <li><strong>Retrieve</strong> data quickly with queries</li>
                <li><strong>Update</strong> and manage data easily</li>
                <li><strong>Maintain</strong> data integrity and security</li>
                <li><strong>Handle</strong> multiple users simultaneously</li>
            </ul>

            <div class="highlight info">
                <strong>Real-world examples:</strong> User accounts, product catalogs, blog posts, orders, messages - all stored in databases!
            </div>
        </div>

        <!-- How PHP Connects to Database -->
        <div class="card">
            <h2>How PHP Works with Databases</h2>

            <div class="diagram">
                <div class="diagram-box">User (Browser)</div>
                <span class="diagram-arrow">→</span>
                <div class="diagram-box">PHP Server</div>
                <span class="diagram-arrow">→</span>
                <div class="diagram-box">MySQL Database</div>
            </div>

            <p>When a user visits your website:</p>
            <ol style="margin-left: 20px; color: #555; line-height: 2;">
                <li>User makes a request (e.g., login form)</li>
                <li>PHP receives the request</li>
                <li>PHP connects to MySQL database</li>
                <li>PHP queries the database (check user credentials)</li>
                <li>Database returns results</li>
                <li>PHP processes and displays the result to user</li>
            </ol>
        </div>

        <!-- MySQL Basics -->
        <div class="card">
            <h2>MySQL Basics</h2>
            <p><strong>MySQL</strong> is the most popular database system used with PHP. It's free, fast, and reliable.</p>

            <h3>Key Concepts</h3>

            <table>
                <tr>
                    <th>Concept</th>
                    <th>Description</th>
                    <th>Real-World Analogy</th>
                </tr>
                <tr>
                    <td><strong>Database</strong></td>
                    <td>Container for all your tables</td>
                    <td>A filing cabinet</td>
                </tr>
                <tr>
                    <td><strong>Table</strong></td>
                    <td>Stores related data in rows and columns</td>
                    <td>A folder in the cabinet</td>
                </tr>
                <tr>
                    <td><strong>Row (Record)</strong></td>
                    <td>A single entry in a table</td>
                    <td>A single document</td>
                </tr>
                <tr>
                    <td><strong>Column (Field)</strong></td>
                    <td>A specific piece of data</td>
                    <td>A field on a form</td>
                </tr>
            </table>
        </div>

        <!-- Example Table -->
        <div class="card">
            <h2>Example: Users Table</h2>
            <p>Here's what a typical <code>users</code> table looks like:</p>

            <table>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>created_at</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>2024-01-15 10:30:00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td>2024-01-16 14:22:00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Bob Wilson</td>
                    <td>bob@example.com</td>
                    <td>2024-01-17 09:15:00</td>
                </tr>
            </table>

            <div class="highlight success">
                <strong>Structure:</strong><br>
                • <strong>id</strong> - Unique identifier (Primary Key)<br>
                • <strong>name</strong> - User's full name<br>
                • <strong>email</strong> - User's email address<br>
                • <strong>created_at</strong> - When the account was created
            </div>
        </div>

        <!-- Data Types -->
        <div class="card">
            <h2>Common MySQL Data Types</h2>

            <div class="data-type-grid">
                <div class="data-type-card">
                    <code>INT</code>
                    <p>Whole numbers</p>
                    <small>Example: 1, 42, 1000</small>
                </div>
                <div class="data-type-card">
                    <code>VARCHAR(n)</code>
                    <p>Variable-length string</p>
                    <small>Example: "Hello", "John"</small>
                </div>
                <div class="data-type-card">
                    <code>TEXT</code>
                    <p>Long text content</p>
                    <small>Example: Blog post body</small>
                </div>
                <div class="data-type-card">
                    <code>DATE</code>
                    <p>Date only</p>
                    <small>Example: 2024-01-15</small>
                </div>
                <div class="data-type-card">
                    <code>DATETIME</code>
                    <p>Date and time</p>
                    <small>Example: 2024-01-15 10:30:00</small>
                </div>
                <div class="data-type-card">
                    <code>BOOLEAN</code>
                    <p>True or False</p>
                    <small>Example: 1 (true) or 0 (false)</small>
                </div>
            </div>
        </div>

        <!-- Primary Keys -->
        <div class="card">
            <h2>Primary Keys</h2>
            <p>Every table should have a <strong>Primary Key</strong> - a column that uniquely identifies each row.</p>

            <div class="highlight">
                <strong>Primary Key Rules:</strong>
                <ul>
                    <li>Must be unique for each row</li>
                    <li>Cannot be NULL (empty)</li>
                    <li>Usually an auto-incrementing <code>id</code> column</li>
                    <li>Used to link tables together (relationships)</li>
                </ul>
            </div>

            <div class="code-block">
<span class="comment">-- Creating a table with a Primary Key</span>
<span class="keyword">CREATE TABLE</span> users (
    id <span class="keyword">INT PRIMARY KEY AUTO_INCREMENT</span>,
    name <span class="keyword">VARCHAR</span>(100),
    email <span class="keyword">VARCHAR</span>(255),
    created_at <span class="keyword">DATETIME</span>
);
            </div>
        </div>

        <!-- Setting Up MySQL -->
        <div class="card">
            <h2>Setting Up MySQL with XAMPP</h2>

            <h3>Step 1: Start Services</h3>
            <ol style="margin-left: 20px; color: #555; line-height: 2;">
                <li>Open XAMPP Control Panel</li>
                <li>Click <strong>Start</strong> next to <strong>Apache</strong></li>
                <li>Click <strong>Start</strong> next to <strong>MySQL</strong></li>
            </ol>

            <h3>Step 2: Open phpMyAdmin</h3>
            <p>Visit <a href="http://localhost/phpmyadmin" target="_blank" style="color: #1e3c72;">http://localhost/phpmyadmin</a> in your browser.</p>

            <h3>Step 3: Create a Database</h3>
            <ol style="margin-left: 20px; color: #555; line-height: 2;">
                <li>Click "New" in the left sidebar</li>
                <li>Enter database name: <code>php_learning</code></li>
                <li>Click "Create"</li>
            </ol>

            <div class="highlight info">
                <strong>phpMyAdmin</strong> is a web-based tool that makes it easy to manage MySQL databases without writing SQL commands directly.
            </div>
        </div>

        <!-- Practice Task -->
        <div class="card">
            <h2>Practice Task</h2>

            <div class="highlight success">
                <strong>Your Task:</strong> Create a <code>users</code> table in phpMyAdmin
            </div>

            <ol style="margin-left: 20px; color: #555; line-height: 2.5;">
                <li>Open phpMyAdmin (<a href="http://localhost/phpmyadmin" target="_blank">localhost/phpmyadmin</a>)</li>
                <li>Create a new database called <code>php_learning</code></li>
                <li>Create a new table called <code>users</code> with 4 columns</li>
                <li>Add these columns:
                    <ul>
                        <li><code>id</code> - INT, Primary Key, AUTO_INCREMENT</li>
                        <li><code>name</code> - VARCHAR(100)</li>
                        <li><code>email</code> - VARCHAR(255)</li>
                        <li><code>created_at</code> - DATETIME</li>
                    </ul>
                </li>
                <li>Insert 2-3 sample users manually</li>
            </ol>
        </div>

        <!-- SQL Preview -->
        <div class="card">
            <h2>Preview: SQL Commands (Day 17)</h2>
            <p>Tomorrow you'll learn these essential SQL commands:</p>

            <div class="code-block">
<span class="comment">-- SELECT: Get data from database</span>
<span class="keyword">SELECT</span> * <span class="keyword">FROM</span> users;

<span class="comment">-- INSERT: Add new data</span>
<span class="keyword">INSERT INTO</span> users (name, email) <span class="keyword">VALUES</span> (<span class="string">'John'</span>, <span class="string">'john@example.com'</span>);

<span class="comment">-- UPDATE: Modify existing data</span>
<span class="keyword">UPDATE</span> users <span class="keyword">SET</span> name = <span class="string">'Johnny'</span> <span class="keyword">WHERE</span> id = 1;

<span class="comment">-- DELETE: Remove data</span>
<span class="keyword">DELETE FROM</span> users <span class="keyword">WHERE</span> id = 1;
            </div>
        </div>

        <!-- Navigation -->
        <div class="nav-buttons">
            <a href="../day15-project/" class="btn">← Day 15: Login Project</a>
            <a href="../day17/" class="btn">Day 17: SQL Basics →</a>
        </div>
    </div>
</body>
</html>
