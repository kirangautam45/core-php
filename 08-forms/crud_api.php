<?php
header('Content-Type: application/json');

// Simple file-based storage
$dataFile = 'users.json';

// Load existing data
$users = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

switch ($method) {
    // CREATE
    case 'POST':
        $user = ['id' => uniqid(), 'name' => $input['name'], 'email' => $input['email']];
        $users[] = $user;
        file_put_contents($dataFile, json_encode($users));
        $response = ['success' => true, 'data' => $user];
        break;

    // READ
    case 'GET':
        if ($id) {
            $user = array_values(array_filter($users, fn($u) => $u['id'] === $id))[0] ?? null;
            $response = $user ? ['success' => true, 'data' => $user] : ['success' => false, 'message' => 'Not found'];
        } else {
            $response = ['success' => true, 'data' => $users];
        }
        break;

    // UPDATE
    case 'PUT':
        foreach ($users as &$user) {
            if ($user['id'] === $id) {
                $user['name'] = $input['name'] ?? $user['name'];
                $user['email'] = $input['email'] ?? $user['email'];
                file_put_contents($dataFile, json_encode($users));
                $response = ['success' => true, 'data' => $user];
                break 2;
            }
        }
        $response = ['success' => false, 'message' => 'Not found'];
        break;

    // DELETE
    case 'DELETE':
        $count = count($users);
        $users = array_values(array_filter($users, fn($u) => $u['id'] !== $id));
        if (count($users) < $count) {
            file_put_contents($dataFile, json_encode($users));
            $response = ['success' => true, 'message' => 'Deleted'];
        } else {
            $response = ['success' => false, 'message' => 'Not found'];
        }
        break;
}

echo json_encode($response, JSON_PRETTY_PRINT);
