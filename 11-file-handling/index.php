<?php
// Day 11: PHP File Handling
// =========================

// 1. WRITING TO A FILE (fopen, fwrite, fclose)
// --------------------------------------------
echo "<h2>1. Writing to a File</h2>";

$file = fopen("myfile.txt", "w");  // "w" = write mode (creates/overwrites)
fwrite($file, "Hello World!\n");
fwrite($file, "This is line 2.\n");
fwrite($file, "PHP is fun!");
fclose($file);

echo "File created successfully!<br><br>";


// 2. READING A FILE (fread)
// -------------------------
echo "<h2>2. Reading Entire File</h2>";

$file = fopen("myfile.txt", "r");  // "r" = read mode
$content = fread($file, filesize("myfile.txt"));
fclose($file);

echo "<pre>$content</pre>";


// 3. READING LINE BY LINE (fgets)
// -------------------------------
echo "<h2>3. Reading Line by Line</h2>";

$file = fopen("myfile.txt", "r");

while (!feof($file)) {        // feof = end of file
    $line = fgets($file);     // get one line
    echo $line . "<br>";
}

fclose($file);


// 4. APPENDING TO A FILE
// ----------------------
echo "<h2>4. Appending to File</h2>";

$file = fopen("myfile.txt", "a");  // "a" = append mode
fwrite($file, "\nNew line added!");
fclose($file);

echo "Line appended!<br>";
echo "<pre>" . file_get_contents("myfile.txt") . "</pre>";


// 5. SHORTCUT FUNCTIONS
// ---------------------
echo "<h2>5. Shortcut Functions</h2>";

// Write entire file in one line
file_put_contents("quick.txt", "Quick write!");

// Read entire file in one line
$data = file_get_contents("quick.txt");
echo $data . "<br><br>";

// Append using shortcut
file_put_contents("quick.txt", "\nAppended!", FILE_APPEND);
echo file_get_contents("quick.txt");


// 6. CHECK IF FILE EXISTS
// -----------------------
echo "<h2>6. File Exists Check</h2>";

if (file_exists("myfile.txt")) {
    echo "File exists!<br>";
    echo "Size: " . filesize("myfile.txt") . " bytes";
} else {
    echo "File not found!";
}


// 7. PRACTICE: SIMPLE LOG SYSTEM
// ------------------------------
echo "<h2>7. Practice: Simple Logger</h2>";

$log = fopen("log.txt", "a");
$time = date("Y-m-d H:i:s");
fwrite($log, "[$time] Page visited\n");
fclose($log);

echo "Log file contents:<br>";
echo "<pre>" . file_get_contents("log.txt") . "</pre>";

?>
