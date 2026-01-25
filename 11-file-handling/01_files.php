<?php
/**
 * DAY 11 - Part 1: Basic File Operations
 * Time: 10 minutes
 *
 * Learning Goals:
 * - Write data to files
 * - Read data from files
 * - Check if files exist
 */

echo "=== BASIC FILE OPERATIONS ===\n\n";

// ============================================
// SECTION 1: WRITING FILES (3 minutes)
// ============================================

echo "--- Writing Files ---\n";

// Method 1: file_put_contents() - The EASY way
$content = "Hello, PHP!\nThis is line 2.\nThis is line 3.";
file_put_contents('sample.txt', $content);
echo "Created sample.txt\n";

// Method 2: Append to file (don't overwrite)
file_put_contents('sample.txt', "\nThis line was appended!", FILE_APPEND);
echo "Appended to sample.txt\n";

// Method 3: Traditional way (fopen/fwrite/fclose)
$file = fopen('traditional.txt', 'w');  // 'w' = write mode
fwrite($file, "Line 1 using fwrite\n");
fwrite($file, "Line 2 using fwrite\n");
fclose($file);
echo "Created traditional.txt using fopen/fwrite\n\n";

// ============================================
// SECTION 2: READING FILES (3 minutes)
// ============================================

echo "--- Reading Files ---\n";

// Method 1: file_get_contents() - Read entire file as string
echo "Reading sample.txt:\n";
$content = file_get_contents('sample.txt');
echo $content . "\n\n";

// Method 2: file() - Read file into array (each line = element)
echo "Reading as array (line by line):\n";
$lines = file('sample.txt', FILE_IGNORE_NEW_LINES);
foreach ($lines as $index => $line) {
    echo "  Line $index: $line\n";
}
echo "\n";

// Method 3: Read line by line (for large files)
echo "Using fgets (line by line):\n";
$file = fopen('sample.txt', 'r');
while (($line = fgets($file)) !== false) {
    echo "  > " . trim($line) . "\n";
}
fclose($file);
echo "\n";

// ============================================
// SECTION 3: FILE CHECKS (2 minutes)
// ============================================

echo "--- File Information ---\n";

$filename = 'sample.txt';

// Check if file exists
if (file_exists($filename)) {
    echo "File exists: YES\n";
    echo "File size: " . filesize($filename) . " bytes\n";
    echo "Last modified: " . date("Y-m-d H:i:s", filemtime($filename)) . "\n";
    echo "Is readable: " . (is_readable($filename) ? "YES" : "NO") . "\n";
    echo "Is writable: " . (is_writable($filename) ? "YES" : "NO") . "\n";
} else {
    echo "File does not exist!\n";
}

echo "\n";

// ============================================
// SECTION 4: DELETE FILES (1 minute)
// ============================================

echo "--- Cleanup ---\n";

// Delete the files we created
if (file_exists('traditional.txt')) {
    unlink('traditional.txt');
    echo "Deleted traditional.txt\n";
}

// Keep sample.txt for the next examples
echo "Keeping sample.txt for next lessons\n";

echo "\n=== END OF BASIC FILE OPERATIONS ===\n";

/*
 * KEY TAKEAWAYS:
 *
 * 1. file_put_contents() - Easiest way to write
 * 2. file_get_contents() - Easiest way to read
 * 3. FILE_APPEND flag - Add to file without overwriting
 * 4. file() - Great for reading line by line
 * 5. Always check file_exists() before reading
 */
?>
