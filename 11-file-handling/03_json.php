<?php
/**
 * DAY 11 - Part 3: JSON File Handling
 * Time: 15 minutes
 *
 * Learning Goals:
 * - Encode PHP arrays/objects to JSON
 * - Decode JSON to PHP
 * - Complete CRUD operations with JSON files
 * - Handle JSON errors
 */

echo "=== JSON FILE HANDLING ===\n\n";

$jsonFile = 'products.json';

// ============================================
// SECTION 1: CREATE - Encoding to JSON (4 minutes)
// ============================================

echo "--- Creating JSON File ---\n";

// PHP array that we want to save
$products = [
    [
        'id' => 1,
        'name' => 'Laptop',
        'price' => 999.99,
        'stock' => 15,
        'category' => 'Electronics'
    ],
    [
        'id' => 2,
        'name' => 'Headphones',
        'price' => 79.99,
        'stock' => 50,
        'category' => 'Electronics'
    ],
    [
        'id' => 3,
        'name' => 'Desk Chair',
        'price' => 249.99,
        'stock' => 8,
        'category' => 'Furniture'
    ],
    [
        'id' => 4,
        'name' => 'Coffee Mug',
        'price' => 12.99,
        'stock' => 100,
        'category' => 'Kitchen'
    ],
];

// Convert to JSON with pretty formatting
$json = json_encode($products, JSON_PRETTY_PRINT);

// Save to file
file_put_contents($jsonFile, $json);

echo "Created $jsonFile\n";
echo "Preview:\n";
echo substr($json, 0, 200) . "...\n\n";

// ============================================
// SECTION 2: READ - Decoding JSON (4 minutes)
// ============================================

echo "--- Reading JSON File ---\n";

// Read file contents
$jsonContent = file_get_contents($jsonFile);

// Decode JSON to PHP array
// true = associative array, false = object
$data = json_decode($jsonContent, true);

// Check for errors
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "JSON Error: " . json_last_error_msg() . "\n";
    exit;
}

echo "Loaded " . count($data) . " products:\n\n";

// Display products in a table format
echo sprintf("%-3s | %-15s | %-10s | %-6s | %s\n",
    'ID', 'Name', 'Price', 'Stock', 'Category');
echo str_repeat('-', 55) . "\n";

foreach ($data as $product) {
    echo sprintf("%-3d | %-15s | $%-9.2f | %-6d | %s\n",
        $product['id'],
        $product['name'],
        $product['price'],
        $product['stock'],
        $product['category']
    );
}
echo "\n";

// ============================================
// SECTION 3: UPDATE - Modify and Save (3 minutes)
// ============================================

echo "--- Updating Product ---\n";

// Find and update product with id = 2
foreach ($data as &$product) {  // Note: & for reference
    if ($product['id'] === 2) {
        $oldPrice = $product['price'];
        $product['price'] = 69.99;  // Sale price!
        $product['stock'] -= 5;      // Sold some
        echo "Updated '{$product['name']}':\n";
        echo "  Price: \${$oldPrice} -> \${$product['price']}\n";
        echo "  Stock: " . ($product['stock'] + 5) . " -> {$product['stock']}\n";
        break;
    }
}
unset($product); // Break reference

// Save changes
file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
echo "Changes saved!\n\n";

// ============================================
// SECTION 4: ADD NEW RECORD (2 minutes)
// ============================================

echo "--- Adding New Product ---\n";

// Create new product
$newProduct = [
    'id' => count($data) + 1,
    'name' => 'USB Cable',
    'price' => 9.99,
    'stock' => 200,
    'category' => 'Electronics'
];

// Add to array
$data[] = $newProduct;

// Save
file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

echo "Added: {$newProduct['name']} (ID: {$newProduct['id']})\n";
echo "Total products: " . count($data) . "\n\n";

// ============================================
// SECTION 5: DELETE & SEARCH (2 minutes)
// ============================================

echo "--- Deleting Product ---\n";

// Delete product with id = 4
$deleteId = 4;
$data = array_filter($data, function($p) use ($deleteId) {
    return $p['id'] !== $deleteId;
});
$data = array_values($data); // Re-index array

file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
echo "Deleted product ID: $deleteId\n";
echo "Remaining products: " . count($data) . "\n\n";

// Search example
echo "--- Searching Products ---\n";
echo "Electronics category:\n";
foreach ($data as $product) {
    if ($product['category'] === 'Electronics') {
        echo "  - {$product['name']}: \${$product['price']}\n";
    }
}

// Low stock alert
echo "\nLow stock (< 20 items):\n";
foreach ($data as $product) {
    if ($product['stock'] < 20) {
        echo "  - {$product['name']}: {$product['stock']} left\n";
    }
}

echo "\n=== END OF JSON HANDLING ===\n";

/*
 * KEY TAKEAWAYS:
 *
 * 1. json_encode($array, JSON_PRETTY_PRINT) - Convert to JSON
 * 2. json_decode($json, true) - Convert to PHP array
 * 3. Always check json_last_error() after decoding
 * 4. Use file_get_contents/file_put_contents for simple read/write
 * 5. Remember to save after making changes!
 *
 * JSON vs CSV:
 * - JSON: Better for complex/nested data
 * - CSV: Better for simple tabular data, Excel compatibility
 */
?>
