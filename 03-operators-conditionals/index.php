<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 03: Operators & Conditionals</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        section {
            padding: 25px 30px;
            border-bottom: 2px solid #f0f0f0;
        }
        section h2 {
            color: #667eea;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
        }
        .output {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
        }
        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        .result-item {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .warning-box {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .success { color: #28a745; font-weight: bold; }
        .danger { color: #dc3545; font-weight: bold; }
        .operator {
            background: #667eea;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
        pre {
            background: #282c34;
            color: #abb2bf;
            padding: 12px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }
        th { background: #667eea; color: white; }
        tr:nth-child(even) { background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Day 03: Operators & Conditionals</h1>
            <p>Essential PHP Concepts</p>
        </header>

        <!-- Section 1: Arithmetic Operators -->
        <section>
            <h2>1. Arithmetic Operators</h2>
            <?php
                $a = 10;
                $b = 3;
            ?>
            <p>Using: <strong>$a = <?php print $a; ?></strong> and <strong>$b = <?php echo $b; ?>
        </strong></p>

            <div class="result-grid">
                <div class="result-item">
                    <strong>Addition <span class="operator">+</span></strong><br>
                    $a + $b = <strong><?php print $a + $b; ?></strong>
                </div>
                <div class="result-item">
                    <strong>Subtraction <span class="operator">-</span></strong><br>
                    $a - $b = <strong><?php print $a - $b; ?></strong>
                </div>
                <div class="result-item">
                    <strong>Multiplication <span class="operator">*</span></strong><br>
                    $a * $b = <strong><?php print $a * $b; ?></strong>
                </div>
                <div class="result-item">
                    <strong>Division <span class="operator">/</span></strong><br>
                    $a / $b = <strong><?php print round($a / $b, 2); ?></strong>
                </div>
                <div class="result-item">
                    <strong>Modulus <span class="operator">%</span></strong><br>
                    $a % $b = <strong><?php print $a % $b; ?></strong>
                </div>
                <div class="result-item">
                    <strong>Exponent <span class="operator">**</span></strong><br>
                    $a ** 2 = <strong><?php print $a ** 2; ?></strong>
                      $b ** 2 = <strong><?php print $b ** 2; ?></strong>
                </div>
            </div>

            <h3>Modulus (%) - Check Even/Odd</h3>
            <div class="output">
                <?php
                    $number = 7;
                    print "<p>\$number = $number</p>";
                    print "<p>$number % 2 = " . ($number % 2) . "</p>";
                    print "<p><strong>Result:</strong> $number is " . ($number % 2 == 0 ? "even" : "odd") . "</p>";
                ?>
            </div>
        </section>

        <!-- Section 2: Comparison Operators -->
        <section>
            <h2>2. Comparison: == vs === </h2>

            <div class="warning-box">
                <strong>Important:</strong> Always prefer <code>===</code> (strict) over <code>==</code> (loose)
            </div>

            <div class="output">
                <h4>Loose Comparison == (compares VALUE only):</h4>
                <pre><?php
                    print "5 == \"5\"   → "; var_dump(5 == "5");
                    print "0 == false  → "; var_dump(0 == false);
                    print "null == false → "; var_dump(null == false);
                ?></pre>
            </div>

            <div class="output">
                <h4>Strict Comparison === (compares VALUE AND TYPE):</h4>
                <pre><?php
                    print "5 === \"5\"  → "; var_dump(5 === "5");
                    print "5 === 5    → "; var_dump(5 === 5);
                    print "0 === false → "; var_dump(0 === false);
                ?></pre>
            </div>

            <h3>Other Comparison Operators</h3>
            <table>
                <tr><th>Expression</th><th>Result</th></tr>
                <tr><td><code>5 > 3</code></td><td class="success">true</td></tr>
                <tr><td><code>5 < 3</code></td><td class="danger">false</td></tr>
                <tr><td><code>5 >= 5</code></td><td class="success">true</td></tr>
                <tr><td><code>5 <= 3</code></td><td class="danger">false</td></tr>
                <tr><td><code>5 != 3</code></td><td class="success">true</td></tr>
            </table>
        </section>

        <!-- Section 3: Logical Operators -->
        <section>
            <h2>3. Logical Operators</h2>

            <table>
                <tr><th>Operator</th><th>Name</th><th>Description</th></tr>
                <tr><td><code>&&</code></td><td>AND</td><td>True if BOTH are true</td></tr>
                <tr><td><code>||</code></td><td>OR</td><td>True if EITHER is true</td></tr>
                <tr><td><code>!</code></td><td>NOT</td><td>Inverts the value</td></tr>
            </table>

            <div class="output">
                <h4>Example: Can this person drive?</h4>
                <?php
                    $age = 25;
                    $hasLicense = true;

                    echo "<p>\$age = $age, \$hasLicense = " . ($hasLicense ? 'true' : 'false') . "</p>";

                    $canDrive = $age >= 18 && $hasLicense;
                    echo "<p>Can drive (\$age >= 18 && \$hasLicense): ";
                    echo "<strong class='" . ($canDrive ? 'success' : 'danger') . "'>";
                    echo ($canDrive ? 'Yes' : 'No') . "</strong></p>";
                ?>
            </div>
        </section>

        <!-- Section 4: if/else/elseif -->
        <section>
            <h2>4. Conditional Statements</h2>

            <h3>The if Statement</h3>
            <div class="output">
                <?php
                    $age = 18;
                    echo "<p>\$age = $age</p>";
                    if ($age >= 18) {
                        echo "<p class='success'>You are an adult.</p>";
                    }
                ?>
            </div>

            <h3>The if-else Statement</h3>
            <div class="output">
                <?php
                    $temperature = 25;
                    echo "<p>\$temperature = $temperature</p>";
                    if ($temperature > 30) {
                        echo "<p>It's hot outside!</p>";
                    } else {
                        echo "<p>The weather is nice.</p>";
                    }
                ?>
            </div>

            <h3>The elseif Statement - Grade Calculator</h3>
            <div class="output">
                <?php
                    $score = 85;
                    echo "<p>\$score = $score</p>";

                    if ($score >= 90) {
                        $grade = "A";
                    } elseif ($score >= 80) {
                        $grade = "B";
                    } elseif ($score >= 70) {
                        $grade = "C";
                    } elseif ($score >= 60) {
                        $grade = "D";
                    } else {
                        $grade = "F";
                    }

                    echo "<p><strong>Grade:</strong> <span style='font-size: 1.5em; color: #28a745;'>$grade</span></p>";
                ?>
            </div>
        </section>

        <!-- Section 5: Ternary Operator -->
        <section>
            <h2>5. Ternary Operator</h2>
            <p><strong>Syntax:</strong> <code>condition ? value_if_true : value_if_false</code></p>

            <div class="output">
                <?php
                    $age = 20;

                    // Long way with if-else
                    echo "<p><strong>Long way:</strong></p>";
                    echo "<pre>if (\$age >= 18) {\n    \$status = \"Adult\";\n} else {\n    \$status = \"Minor\";\n}</pre>";

                    // Short way with ternary
                    $status = $age >= 18 ? "Adult" : "Minor";
                    echo "<p><strong>Short way:</strong> \$status = \$age >= 18 ? \"Adult\" : \"Minor\";</p>";
                    echo "<p><strong>Result:</strong> $status</p>";
                ?>
            </div>

            <div class="output">
                <h4>Practical Examples:</h4>
                <?php
                    $isLoggedIn = true;
                    echo "<p>Status: <strong>" . ($isLoggedIn ? "Online" : "Offline") . "</strong></p>";

                    $items = 5;
                    echo "<p>You have $items " . ($items === 1 ? "item" : "items") . " in your cart.</p>";
                ?>
            </div>
        </section>

        <!-- Section 6: Practice -->
        <section>
            <h2>6. Practice: Shopping Cart</h2>
            <?php
                $itemPrice = 29.99;
                $quantity = 3;
                $isMember = true;
                $discountRate = 0.10;
                $taxRate = 0.08;

                $subtotal = $itemPrice * $quantity;
                $discount = $isMember ? $subtotal * $discountRate : 0;
                $tax = ($subtotal - $discount) * $taxRate;
                $total = $subtotal - $discount + $tax;
            ?>
            <div class="output">
                <p>Item Price: $<?php echo number_format($itemPrice, 2); ?> x <?php echo $quantity; ?></p>
                <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
                <p class="success">Member Discount (10%): -$<?php echo number_format($discount, 2); ?></p>
                <p>Tax (8%): $<?php echo number_format($tax, 2); ?></p>
                <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
            </div>
        </section>

        <!-- Key Takeaways -->
        <section style="background: #f8f9fa;">
            <h2>Key Takeaways</h2>
            <ul style="padding-left: 20px;">
                <li>Arithmetic: <code>+ - * / % **</code></li>
                <li>Use <code>===</code> instead of <code>==</code> for safe comparisons</li>
                <li>Logical: <code>&&</code> (AND), <code>||</code> (OR), <code>!</code> (NOT)</li>
                <li>Use <code>if/elseif/else</code> for conditions</li>
                <li>Ternary <code>?:</code> is a shortcut for simple if-else</li>
            </ul>
        </section>

        <section style="text-align: center; padding: 15px;">
            <p style="color: #666;">Day 03 - PHP <?php echo PHP_VERSION; ?></p>
        </section>
    </div>
</body>
</html>
