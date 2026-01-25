<?php
/**
 * DAY 11 - Practice Exercise: Contact Book
 *
 * TASK: Complete the functions below to create a contact management system
 * that stores contacts in a JSON file.
 *
 * Run with: php 04_practice.php
 */

$contactsFile = 'contacts.json';

// ============================================
// HELPER FUNCTIONS (Complete these!)
// ============================================

/**
 * Load contacts from JSON file
 * @return array Array of contacts (empty array if file doesn't exist)
 */
function loadContacts($file) {
    // TODO: Check if file exists
    // TODO: Read file and decode JSON
    // TODO: Return array of contacts (or empty array)

    // YOUR CODE HERE:

    return [];
}

/**
 * Save contacts to JSON file
 * @param string $file Filename
 * @param array $contacts Array of contacts
 * @return bool Success status
 */
function saveContacts($file, $contacts) {
    // TODO: Encode contacts as JSON (pretty print)
    // TODO: Write to file
    // TODO: Return true on success

    // YOUR CODE HERE:

    return false;
}

/**
 * Add a new contact
 * @return array The new contact with auto-generated ID
 */
function addContact($file, $name, $phone, $email) {
    // TODO: Load existing contacts
    // TODO: Generate new ID (max ID + 1)
    // TODO: Create contact array
    // TODO: Add to contacts
    // TODO: Save and return new contact

    // YOUR CODE HERE:

    return [];
}

/**
 * Find contact by name (partial match, case-insensitive)
 * @return array Matching contacts
 */
function searchContacts($file, $searchTerm) {
    // TODO: Load contacts
    // TODO: Filter by name containing search term
    // TODO: Return matches

    // YOUR CODE HERE:

    return [];
}

/**
 * Delete contact by ID
 * @return bool True if deleted, false if not found
 */
function deleteContact($file, $id) {
    // TODO: Load contacts
    // TODO: Filter out contact with matching ID
    // TODO: Save and return success status

    // YOUR CODE HERE:

    return false;
}

// ============================================
// TEST YOUR IMPLEMENTATION
// ============================================

echo "=== CONTACT BOOK PRACTICE ===\n\n";

// Test 1: Add contacts
echo "Adding contacts...\n";
$contact1 = addContact($contactsFile, 'John Doe', '555-1234', 'john@email.com');
$contact2 = addContact($contactsFile, 'Jane Smith', '555-5678', 'jane@email.com');
$contact3 = addContact($contactsFile, 'Johnny Appleseed', '555-9999', 'johnny@email.com');

echo "Added: " . ($contact1 ? $contact1['name'] : 'FAILED') . "\n";
echo "Added: " . ($contact2 ? $contact2['name'] : 'FAILED') . "\n";
echo "Added: " . ($contact3 ? $contact3['name'] : 'FAILED') . "\n\n";

// Test 2: Load and display all
echo "All contacts:\n";
$contacts = loadContacts($contactsFile);
foreach ($contacts as $c) {
    echo "  #{$c['id']} - {$c['name']} | {$c['phone']} | {$c['email']}\n";
}
echo "\n";

// Test 3: Search
echo "Searching for 'john':\n";
$results = searchContacts($contactsFile, 'john');
foreach ($results as $c) {
    echo "  Found: {$c['name']}\n";
}
echo "\n";

// Test 4: Delete
echo "Deleting contact #1...\n";
$deleted = deleteContact($contactsFile, 1);
echo "Delete result: " . ($deleted ? 'SUCCESS' : 'FAILED') . "\n\n";

// Final state
echo "Final contact list:\n";
$contacts = loadContacts($contactsFile);
if (empty($contacts)) {
    echo "  (No contacts - complete the functions above!)\n";
} else {
    foreach ($contacts as $c) {
        echo "  #{$c['id']} - {$c['name']}\n";
    }
}

echo "\n=== END OF PRACTICE ===\n";

/*
 * SOLUTION HINTS:
 *
 * loadContacts():
 *   - Use file_exists() to check
 *   - Use file_get_contents() to read
 *   - Use json_decode($content, true) to parse
 *
 * saveContacts():
 *   - Use json_encode($contacts, JSON_PRETTY_PRINT)
 *   - Use file_put_contents() to write
 *
 * addContact():
 *   - Get max ID: array_column($contacts, 'id') then max()
 *   - Handle empty array case for first contact
 *
 * searchContacts():
 *   - Use stripos() for case-insensitive search
 *   - Use array_filter() to filter matches
 *
 * deleteContact():
 *   - Use array_filter() to remove by ID
 *   - Use array_values() to re-index
 */
?>
