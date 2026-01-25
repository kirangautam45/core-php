<?php
header('Content-Type: application/json');
// Handle JSON input
$input = json_decode(file_get_contents('php://input'), true);
// Also accept form data
if (!$input) {
    $input = $_POST;
}
$response = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';

    if (!empty($username)) {
        $response = [
            'success' => true,
            'message' => "Welcome, $username!",
            'data' => [
                'username' => $username
            ]
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Username is required'
        ];
    }
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $q = $_GET['any'] ?? '';

    if (!empty($q)) {
        $response = [
            'success' => true,
            'message' => "Search results for: $q",
            'data' => [
                'query' => $q
            ]
        ];
    } else {
        $response = [
            'success' => true,
            'message' => 'API is running',
            'endpoints' => [
                'POST /' => 'Login with username and password',
                'GET /?q=term' => 'Search'
            ]
        ];
    }
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}
