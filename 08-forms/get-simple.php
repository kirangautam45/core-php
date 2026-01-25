<?php
// Minimum GET example
$q = $_GET['q'] ?? '';

if ($q) {
    echo "You searched: " . htmlspecialchars($q);
} else {
    echo "Add ?q=yourterm to the URL";
}
