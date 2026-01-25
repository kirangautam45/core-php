<!DOCTYPE html>
<html>
<head>
    <title>Day 19: Forms to Database</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container { max-width: 700px; }
        .lesson-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .lesson-card h3 {
            margin: 0 0 10px;
            color: #1a1a2e;
        }
        .lesson-card p {
            color: #6c757d;
            margin: 0 0 15px;
        }
        .lesson-card a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .lesson-card a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .topics {
            display: grid;
            gap: 12px;
            margin: 25px 0;
        }
        .topic {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topic-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .topic-text {
            flex: 1;
        }
        .topic-text strong {
            display: block;
            color: #1a1a2e;
        }
        .topic-text span {
            font-size: 13px;
            color: #6c757d;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-beginner { background: #d4edda; color: #155724; }
        .badge-intermediate { background: #fff3cd; color: #856404; }
        .badge-advanced { background: #cce5ff; color: #004085; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Day 19: Forms to Database</h1>

        <p style="text-align: center; color: #6c757d; margin-bottom: 30px;">
            Learn how to capture user input and store it securely in MySQL
        </p>

        <h2>What You'll Learn</h2>

        <div class="topics">
            <div class="topic">
                <div class="topic-icon">1</div>
                <div class="topic-text">
                    <strong>Form Handling</strong>
                    <span>Process POST requests and retrieve form data</span>
                </div>
            </div>

            <div class="topic">
                <div class="topic-icon">2</div>
                <div class="topic-text">
                    <strong>Input Validation</strong>
                    <span>Validate user input before saving to database</span>
                </div>
            </div>

            <div class="topic">
                <div class="topic-icon">3</div>
                <div class="topic-text">
                    <strong>Prepared Statements</strong>
                    <span>Prevent SQL injection with parameterized queries</span>
                </div>
            </div>

            <div class="topic">
                <div class="topic-icon">4</div>
                <div class="topic-text">
                    <strong>Password Hashing</strong>
                    <span>Securely store passwords using password_hash()</span>
                </div>
            </div>

            <div class="topic">
                <div class="topic-icon">5</div>
                <div class="topic-text">
                    <strong>Error Handling</strong>
                    <span>Display user-friendly error messages</span>
                </div>
            </div>
        </div>

        <h2>Lessons</h2>

        <div class="lesson-card">
            <span class="badge badge-beginner">Beginner</span>
            <h3>1. Basic Form to Database</h3>
            <p>Simple contact form that saves data directly to MySQL using prepared statements.</p>
            <a href="1_basic_form.php">Start Lesson</a>
        </div>

        <div class="lesson-card">
            <span class="badge badge-intermediate">Intermediate</span>
            <h3>2. Form Validation</h3>
            <p>Server-side validation with error messages. Learn to validate required fields, email format, and string length.</p>
            <a href="2_validation.php">Start Lesson</a>
        </div>

        <div class="lesson-card">
            <span class="badge badge-advanced">Advanced</span>
            <h3>3. User Registration</h3>
            <p>Complete registration system with password hashing, confirmation matching, and duplicate checking.</p>
            <a href="3_registration.php">Start Lesson</a>
        </div>

        <div class="info" style="margin-top: 30px;">
            <strong>Database Setup:</strong> Make sure you have created the <code>day19_practice</code> database and the required tables before starting.
        </div>

        <div class="footer-text">
            Day 19 of 30 Days PHP
        </div>
    </div>
</body>
</html>
