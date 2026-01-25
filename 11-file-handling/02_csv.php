<?php
/**
 * DAY 11 - Part 2: CSV File Handling
 * Time: 15 minutes
 *
 * Learning Goals:
 * - Create CSV files with headers
 * - Read and parse CSV data
 * - Search within CSV files
 * - Add new records
 */

echo "=== CSV FILE HANDLING ===\n\n";

$csvFile = 'students.csv';

// ============================================
// SECTION 1: CREATE CSV FILE (4 minutes)
// ============================================

echo "--- Creating CSV File ---\n";

// Open file for writing
$file = fopen($csvFile, 'w');

// Write header row
fputcsv($file, ['ID', 'Name', 'Email', 'Grade']);

// Write data rows
$students = [
    [1, 'Alice Johnson', 'alice@email.com', 85],
    [2, 'Bob Smith', 'bob@email.com', 92],
    [3, 'Charlie Brown', 'charlie@email.com', 78],
    [4, 'Diana Ross', 'diana@email.com', 95],
    [5, 'Eve Wilson', 'eve@email.com', 88],
];

foreach ($students as $student) {
    fputcsv($file, $student);
}

fclose($file);
echo "Created $csvFile with " . count($students) . " students\n\n";

// ============================================
// SECTION 2: READ CSV FILE (4 minutes)
// ============================================

echo "--- Reading CSV File ---\n";

$file = fopen($csvFile, 'r');

// Read header row first
$headers = fgetcsv($file);
echo "Headers: " . implode(' | ', $headers) . "\n";
echo str_repeat('-', 50) . "\n";

// Read all data rows
$allStudents = [];
while (($row = fgetcsv($file)) !== false) {
    // Combine headers with values to create associative array
    $student = array_combine($headers, $row);
    $allStudents[] = $student;

    // Display formatted
    printf("%-3s | %-15s | %-20s | %s\n",
        $student['ID'],
        $student['Name'],
        $student['Email'],
        $student['Grade']
    );
}
fclose($file);
echo "\n";

// ============================================
// SECTION 3: SEARCH CSV DATA (4 minutes)
// ============================================

echo "--- Searching CSV Data ---\n";

// Search for students with grade >= 90
echo "Students with A grade (90+):\n";
foreach ($allStudents as $student) {
    if ($student['Grade'] >= 90) {
        echo "  - {$student['Name']}: {$student['Grade']}\n";
    }
}
echo "\n";

// Search by name (case-insensitive)
$searchName = 'bob';
echo "Searching for '$searchName':\n";
foreach ($allStudents as $student) {
    if (stripos($student['Name'], $searchName) !== false) {
        echo "  Found: {$student['Name']} ({$student['Email']})\n";
    }
}
echo "\n";

// ============================================
// SECTION 4: ADD NEW RECORD (3 minutes)
// ============================================

echo "--- Adding New Student ---\n";

// Open in append mode
$file = fopen($csvFile, 'a');

// Add new student
$newStudent = [6, 'Frank Miller', 'frank@email.com', 82];
fputcsv($file, $newStudent);

fclose($file);
echo "Added: {$newStudent[1]}\n\n";

// Verify by reading again
echo "--- Updated Student List ---\n";
$file = fopen($csvFile, 'r');
fgetcsv($file); // Skip header

while (($row = fgetcsv($file)) !== false) {
    echo "  {$row[0]}. {$row[1]} - Grade: {$row[3]}\n";
}
fclose($file);

// ============================================
// SECTION 5: CALCULATE STATISTICS
// ============================================

echo "\n--- Class Statistics ---\n";

// Re-read for calculations
$file = fopen($csvFile, 'r');
fgetcsv($file); // Skip header

$grades = [];
while (($row = fgetcsv($file)) !== false) {
    $grades[] = (int)$row[3];
}
fclose($file);

$total = array_sum($grades);
$count = count($grades);
$average = $total / $count;
$highest = max($grades);
$lowest = min($grades);

echo "Total students: $count\n";
echo "Average grade: " . number_format($average, 1) . "\n";
echo "Highest grade: $highest\n";
echo "Lowest grade: $lowest\n";

echo "\n=== END OF CSV HANDLING ===\n";

/*
 * KEY TAKEAWAYS:
 *
 * 1. fputcsv() - Write array as CSV row (handles commas, quotes)
 * 2. fgetcsv() - Read CSV row as array
 * 3. array_combine() - Create associative array from headers + values
 * 4. Use 'a' mode to append without overwriting
 * 5. Always skip header row when reading data
 */
?>
