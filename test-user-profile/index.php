<?php
session_start();

// If logged in, redirect to profile
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

// If not logged in, redirect to login
header('Location: login.php');
exit;
