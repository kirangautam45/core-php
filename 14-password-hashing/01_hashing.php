<?php
/**
 * DAY 14 - Part 1: Password Hashing Basics
 * Time: 10 minutes
 *
 * Learning Goals:
 * - Understand password_hash() and password_verify()
 * - See why same password produces different hashes
 * - Learn about hash algorithms
 */

echo "=== PASSWORD HASHING BASICS ===\n\n";

// ============================================
// SECTION 1: Why Hash Passwords?
// ============================================

echo "--- Why Hash Passwords? ---\n";
echo "
Imagine your database gets hacked. If passwords are stored as:

  Plain text:  'password123'    → Hacker knows password instantly!
  MD5 hash:    '482c811...'     → Cracked in seconds (rainbow tables)
  Bcrypt hash: '\$2y\$10\$...'     → Would take years to crack!

PHP's password_hash() uses bcrypt - intentionally SLOW to prevent cracking.
\n";

// ============================================
// SECTION 2: Creating Hashes
// ============================================

echo "--- Creating Hashes ---\n\n";

$password = "mySecurePassword123";

// Create a hash (this is what you store in database)
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Original password: $password\n";
echo "Hashed password:   $hash\n";
echo "Hash length:       " . strlen($hash) . " characters\n\n";

// IMPORTANT: Same password produces DIFFERENT hashes each time!
echo "Same password, different hashes (due to random salt):\n";
for ($i = 1; $i <= 3; $i++) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    echo "  Hash $i: $newHash\n";
}
echo "\n";

// ============================================
// SECTION 3: Verifying Passwords
// ============================================

echo "--- Verifying Passwords ---\n\n";

// This is the hash stored in your database
$storedHash = password_hash("correctPassword", PASSWORD_DEFAULT);

// User attempts to login
$attempts = [
    "correctPassword",   // Should pass
    "wrongPassword",     // Should fail
    "CorrectPassword",   // Should fail (case sensitive!)
    "correctPassword ",  // Should fail (has space)
];

echo "Stored hash: $storedHash\n\n";

foreach ($attempts as $attempt) {
    $result = password_verify($attempt, $storedHash);
    $status = $result ? "✓ MATCH" : "✗ NO MATCH";
    echo "  '$attempt' => $status\n";
}
echo "\n";

// ============================================
// SECTION 4: Understanding the Hash
// ============================================

echo "--- Hash Information ---\n\n";

$hash = password_hash("test", PASSWORD_DEFAULT);
$info = password_get_info($hash);

echo "Hash: $hash\n\n";
echo "Algorithm: {$info['algoName']} (code: {$info['algo']})\n";
echo "Options: " . json_encode($info['options']) . "\n\n";

// Breaking down the hash format: $algorithm$cost$salt+hash
// $2y$10$xxxxxxxxxxxxxxxxxxxxxx.yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy
//  ^   ^  ^                     ^
//  |   |  |                     +-- The actual hash (31 chars)
//  |   |  +-- Salt (22 chars)
//  |   +-- Cost factor (10 = 2^10 = 1024 iterations)
//  +-- Algorithm (2y = bcrypt)

echo "Hash breakdown:\n";
echo "  \$2y = Bcrypt algorithm\n";
echo "  \$10 = Cost factor (2^10 iterations)\n";
echo "  Next 22 chars = Random salt\n";
echo "  Remaining = The actual hash\n\n";

// ============================================
// SECTION 5: Rehashing Check
// ============================================

echo "--- Rehashing Check ---\n\n";

// Sometimes PHP updates the default algorithm
// This function checks if a hash needs updating
$oldHash = password_hash("test", PASSWORD_DEFAULT);

if (password_needs_rehash($oldHash, PASSWORD_DEFAULT)) {
    echo "Hash needs to be updated to new algorithm!\n";
} else {
    echo "Hash is using current algorithm. No update needed.\n";
}

echo "\n=== END OF HASHING BASICS ===\n";

/*
 * KEY TAKEAWAYS:
 *
 * 1. password_hash($password, PASSWORD_DEFAULT) - Create hash
 * 2. password_verify($password, $hash) - Check password
 * 3. Same password = different hashes (random salt)
 * 4. NEVER compare hashes directly with ==
 * 5. PASSWORD_DEFAULT auto-updates to best algorithm
 * 6. password_needs_rehash() checks if update needed
 */
?>
