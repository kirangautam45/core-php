<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 02: Variables & Data Types</title>
    <style>
        * {
            margin: 0;
            padding: 0;x
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .section {
            padding: 30px 40px;
            border-bottom: 2px solid #f0f0f0;
        }
        .section:last-child {
            border-bottom: none;
        }
        .section h2 {
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .section h3 {
            color: #764ba2;
            margin: 20px 0 10px 0;
        }
        .output {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
        }
        .output h4 {
            color: #28a745;
            margin-bottom: 10px;
        }
        .card {
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        table th {
            background: #667eea;
            color: white;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        pre {
            background: #282c34;
            color: #abb2bf;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 10px 0;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .variable-name {
            color: #e83e8c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📦 Day 02: Variables & Data Types</h1>
            <p>Working PHP Examples with Real Output</p>
        </header>

        <!-- Section 1: Basic Variables -->
        <section class="section">
            <h2>1. Basic Variables</h2>
            <?php
                $name = "John Doe";
                $age = 25;
                $_private = "secret_data";
                $userName123 = "johndoe123";
            ?>
            <div class="output">
                <h4> Variables Created:</h4>
                <p><span class="variable-name">$name</span> = <?php echo $name; ?></p>
                <p><span class="variable-name">$age</span> = <?php echo $age; ?></p>
                <p><span class="variable-name">$_private</span> = <?php print $_private; ?></p>
            <p><span class="variable-name">$userName123</span> = 
            <?php print $userName123; ?></p>
            </div> </section>

        <!-- Section 2: String Data Type -->
        <section class="section">
            <h2>2. String Data Type</h2>
            <?php
                $singleQuote = 'Hello World';
                $doubleQuote = "Hello World";
                $personName = "Alice";
            ?>
            
            <h3>Single vs Double Quotes</h3>
            <div class="output">
                <p>Single quote: <?php echo $singleQuote; ?></p>
                <p>Double quote: <?php echo $doubleQuote; ?></p>
                <p>With variable (double): <?php print "Hello, $personName"; ?></p>
                <p>With variable (single): <?php print 'Hello, $personName'; ?></p>
            </div>
    </section>

        <!-- Section 3: Integer Data Type -->
        <section class="section">
            <h2>3. Integer Data Type</h2>
            <?php
                $positive = 42;
                $negative = -17;
                $zero = 0;
                $decimal = 255;
                $octal = 0377;
                $hex = 0xFF;
                $binary = 0b11111111;
            ?>
            <div class="output">
                <h4>Different Integer Representations:</h4>
                <p>Decimal: <?php echo $decimal; ?></p>
                <p>Octal (0377): <?php echo $octal; ?></p>
                <p>Hexadecimal (0xFF): <?php print $hex; ?></p>
                <p>Binary (0b11111111): <?php print $binary; ?></p>
                <p class="success">All equal 255! ✓</p>
            </div>
        </section>

        <!-- Section 4: Float Data Type -->
        <section class="section">
            <h2>4. Float (Double) Data Type</h2>
            <?php
                $price = 19.99;
                $pi = 3.14159;
                $negativeFloat = -2.5;
                $big = 1.2e3;
                $small = 7.5e-2;
            ?>
            <div class="output">
                <h4>Float Examples:</h4>
                <p>Price: $<?php echo $price; ?></p>
                <p>Pi: <?php echo $pi; ?></p>
                <p>Negative: <?php echo $negativeFloat; ?></p>
                <p>Scientific (1.2e+3): <?php print $big; ?>
                 (as scientific: <?php printf("%.1e", $big); ?>)</p>
                <p>Scientific (7.5e-2): <?php print $small; ?> 
                (as scientific: <?php printf("%.1e", $small); ?>)</p>
            </div>
        </section>

        <!-- Section 5: Boolean Data Type -->
        <section class="section">
            <h2>5. Boolean Data Type</h2>
            <?php
                $isActive = true;
                $isDeleted = false;
                $isLoggedIn = true;
            ?>
            <div class="output">
                <h4>Boolean Values:</h4>
                <p>isActive: <?php echo $isActive ? 'true' : 'false'; ?></p>
                <p>isDeleted: <?php echo $isDeleted ? 'true' : 'false'; ?></p>
                <p>isLoggedIn: <?php echo $isLoggedIn ? 'true' : 'false'; ?></p>
                
                <?php if ($isLoggedIn): ?>
                    <p class="success">✓ Welcome back! (Condition is true)</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Section 6: Array Data Type -->
        <section class="section">
            <h2>6. Array Data Type (Preview)</h2>
            <?php
                $colors = ["red", "green", "blue"];
                $person = [
                    "name" => "John",
                    "age" => 25,
                    "city" => "New York"
                ];
            ?>
            <div class="output">
                <h4>Indexed Array:</h4>
                <pre><?php print_r($colors); ?></pre>
                
                <h4>Associative Array:</h4>
                <pre><?php print_r($person); ?></pre>
            </div>
        </section>

        <!-- Section 7: NULL Data Type -->
        <section class="section">
            <h2>7. NULL Data Type</h2>
            <?php
                $empty = null;
            ?>
            <div class="output">
                <h4>NULL Value:</h4>
                <p>$empty: <?php var_dump($empty); ?></p>
            </div>
        </section>

        <!-- Section 8: Checking Data Types -->
        <section class="section">
            <h2>8. Checking Data Types</h2>
            <?php
                $testString = "Hello";
                $testInt = 42;
                $testFloat = 3.14;
                $testBool = true;
                $testNull = null;
                $testArray = [1, 2, 3];
            ?>
            
            <h3>Using gettype()</h3>
            <div class="output">
                <p>gettype("Hello"): <strong><?php echo gettype($testString); ?></strong></p>
                <p>gettype(42): <strong><?php echo gettype($testInt); ?></strong></p>
                <p>gettype(3.14): <strong><?php echo gettype($testFloat); ?></strong></p>
                <p>gettype(true): <strong><?php echo gettype($testBool); ?></strong></p>
                <p>gettype(null): <strong><?php echo gettype($testNull); ?></strong></p>
                <p>gettype([1,2,3]): <strong><?php echo gettype($testArray); ?></strong></p>
            </div>

            <h3>Type-Checking Functions</h3>
            <div class="output">
                <p>is_string("Hello"): <strong><?php echo is_string($testString) ? 'true' : 'false'; ?></strong></p>
                <p>is_int(42): <strong><?php echo is_int($testInt) ? 'true' : 'false'; ?></strong></p>
                <p>is_float(3.14): <strong><?php echo is_float($testFloat) ? 'true' : 'false'; ?></strong></p>
                <p>is_bool(true): <strong><?php echo is_bool($testBool) ? 'true' : 'false'; ?></strong></p>
                <p>is_null(null): <strong><?php echo is_null($testNull) ? 'true' : 'false'; ?></strong></p>
                <p>is_numeric("123"): <strong><?php echo is_numeric("123") ? 'true' : 'false'; ?></strong></p>
            </div>
        </section>

        <!-- Section 9: var_dump() and print_r() -->
        <section class="section">
            <h2>9. Debugging Functions</h2>
            <?php
                $debugName = "John";
                $debugAge = 25;
                $debugColors = ["red", "green", "blue"];
            ?>
            
            <h3>var_dump() - Detailed Information</h3>
            <div class="output">
                <pre><?php var_dump($debugName); ?></pre>
                <pre><?php var_dump($debugAge); ?></pre>
                <pre><?php var_dump($debugColors); ?></pre>
            </div>

            <h3>print_r() - Human Readable</h3>
            <div class="output">
                <pre><?php print_r($debugColors); ?></pre>
            </div>
        </section>

        <!-- Section 10: String Concatenation -->
        <section class="section">
            <h2>10. String Concatenation</h2>
            <?php
                $firstName = "John";
                $lastName = "Doe";
                $fullName = $firstName . " " . $lastName;
                
                $greeting = "Hello";
                $greeting .= " World";
            ?>
            <div class="output">
                <h4>Using Dot (.) Operator:</h4>
                <p>$firstName . " " . $lastName = <strong><?php echo $fullName; ?></strong></p>
                
                <h4>Concatenation Assignment (.=):</h4>
                <p>$greeting .= " World" = <strong><?php echo $greeting; ?></strong></p>
                
                <h4>Variable Interpolation:</h4>
                <?php
                    $personAge = 25;
                    $message = "My name is $firstName and I am $personAge years old.";
                ?>
                <p><?php echo $message; ?></p>
            </div>
        </section>

        <!-- Section 11: Type Juggling -->
        <section class="section">
            <h2>11. Type Juggling (Automatic Conversion)</h2>
            <?php
                $stringNum = "10";
                $result1 = $stringNum + 5;
                $result2 = "Age: " . 25;
                $result3 = (int)"10 apples" + 5; // Cast to int first to avoid warning in PHP 8+
            ?>
            <div class="output">
                <h4>Automatic Type Conversion:</h4>
                <p>"10" + 5 = <?php echo $result1; ?> (type: <?php echo gettype($result1); ?>)</p>
                <p>"Age: " . 25 = <?php echo $result2; ?> (type: <?php echo gettype($result2); ?>)</p>
                <p>(int)"10 apples" + 5 = <?php echo $result3; ?> (type: <?php echo gettype($result3); ?>)</p>
            </div>

            <h3>Explicit Type Casting</h3>
            <?php
                $stringValue = "42";
                $intValue = (int) $stringValue;
                $floatValue = (float) $stringValue;
                $boolValue = (bool) $stringValue;
            ?>
            <div class="output">
                <p>(int) "42" = <?php echo $intValue; ?> (<?php echo gettype($intValue); ?>)</p>
                <p>(float) "42" = <?php echo $floatValue; ?> (<?php echo gettype($floatValue); ?>)</p>
                <p>(bool) "42" = <?php echo $boolValue ? 'true' : 'false'; ?> (<?php echo gettype($boolValue); ?>)</p>
            </div>
        </section>

        <!-- Section 12: Constants -->
        <section class="section">
            <h2>12. Constants</h2>
            <?php
                define("SITE_NAME", "My Awesome Website");
                define("MAX_USERS", 100);
                const PI = 3.14159;
                const DEBUG_MODE = true;
            ?>
            <div class="output">
                <h4>User-Defined Constants:</h4>
                <p>SITE_NAME = <strong><?php echo SITE_NAME; ?></strong></p>
                <p>MAX_USERS = <strong><?php echo MAX_USERS; ?></strong></p>
                <p>PI = <strong><?php echo PI; ?></strong></p>
                <p>DEBUG_MODE = <strong><?php echo DEBUG_MODE ? 'true' : 'false'; ?></strong></p>
            </div>

            <h3>Built-in Constants</h3>
            <div class="output">
                <p>PHP_VERSION = <strong><?php echo PHP_VERSION; ?></strong></p>
                <p>PHP_INT_MAX = <strong><?php echo PHP_INT_MAX; ?></strong></p>
                <p>__FILE__ = <strong><?php echo __FILE__; ?></strong></p>
                <p>__LINE__ = <strong><?php echo __LINE__; ?></strong></p>
            </div>
        </section>

        <!-- Section 13: Practice Example 1 -->
        <section class="section">
            <h2>13. Practice Example: Personal Information</h2>
            <?php
                $profileName = "John Doe";
                $profileAge = 25;
                $profileHeight = 5.9;
                $profileIsStudent = true;
            ?>
            <div class="card">
                <h3>Personal Information</h3>
                <p><strong>Name:</strong> <?php echo $profileName; ?></p>
                <p><strong>Age:</strong> <?php echo $profileAge; ?> years old</p>
                <p><strong>Height:</strong> <?php echo $profileHeight; ?> feet</p>
                <p><strong>Student:</strong> <?php echo $profileIsStudent ? "Yes" : "No"; ?></p>
                
                <h4>Debug Info:</h4>
                <pre><?php var_dump($profileName, $profileAge, $profileHeight, $profileIsStudent); ?></pre>
            </div>
        </section>

        <!-- Section 14: Practice Example 2 -->
        <section class="section">
            <h2>14. Practice Example: Shopping Cart</h2>
            <?php
                $productName = "Wireless Mouse";
                $productPrice = 29.99;
                $productQuantity = 2;
                $productInStock = true;
                $productTotal = $productPrice * $productQuantity;
            ?>
            <div class="card">
                <h3><?php echo $productName; ?></h3>
                <p><strong>Price:</strong> $<?php echo $productPrice; ?></p>
                <p><strong>Quantity:</strong> <?php echo $productQuantity; ?></p>
                <p><strong>Total:</strong> $<?php echo number_format($productTotal, 2); ?></p>
                <p><strong>Status:</strong> 
                    <span class="<?php echo $productInStock ? 'success' : ''; ?>">
                        <?php echo $productInStock ? "In Stock ✓" : "Out of Stock"; ?>
                    </span>
                </p>
            </div>
        </section>

        <!-- Section 15: Type Investigation Table -->
        <section class="section">
            <h2>15. Type Investigation Table</h2>
            <?php
                $investigateValues = [
                    42,
                    3.14,
                    "Hello",
                    true,
                    false,
                    null,
                    [1, 2, 3]
                ];
            ?>
            <table>
                <tr>
                    <th>Value</th>
                    <th>Type</th>
                    <th>var_dump()</th>
                </tr>
                <?php foreach ($investigateValues as $val): ?>
                <tr>
                    <td><?php echo is_array($val) ? 'Array' : (is_null($val) ? 'NULL' : $val); ?></td>
                    <td><strong><?php echo gettype($val); ?></strong></td>
                    <td><pre style="margin:0; padding:5px; background:#f8f9fa;"><?php var_dump($val); ?></pre></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- Summary Table -->
        <section class="section">
            <h2>16. Key Takeaways Summary</h2>
            <table>
                <tr>
                    <th>Concept</th>
                    <th>Syntax</th>
                    <th>Example Output</th>
                </tr>
                <tr>
                    <td>Variable</td>
                    <td>$name = "value";</td>
                    <td><?php $ex1 = "John"; echo $ex1; ?></td>
                </tr>
                <tr>
                    <td>String</td>
                    <td>"text" or 'text'</td>
                    <td><?php echo "Hello World"; ?></td>
                </tr>
                <tr>
                    <td>Integer</td>
                    <td>42</td>
                    <td><?php echo 42; ?></td>
                </tr>
                <tr>
                    <td>Float</td>
                    <td>3.14</td>
                    <td><?php echo 3.14; ?></td>
                </tr>
                <tr>
                    <td>Boolean</td>
                    <td>true/false</td>
                    <td><?php echo true ? 'true' : 'false'; ?></td>
                </tr>
                <tr>
                    <td>Get Type</td>
                    <td>gettype($var)</td>
                    <td><?php echo gettype("test"); ?></td>
                </tr>
                <tr>
                    <td>Constant</td>
                    <td>define("NAME", val)</td>
                    <td><?php define("EX_CONST", "Value"); echo EX_CONST; ?></td>
                </tr>
            </table>
        </section>

        <section class="section" style="text-align: center; background: #f8f9fa;">
            <p style="color: #666; font-size: 0.9em;">
                <strong>Day 02 Complete!</strong> All examples executed with PHP <?php echo PHP_VERSION; ?>
            </p>
        </section>
    </div>
</body>
</html>