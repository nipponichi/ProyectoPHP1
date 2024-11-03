<?php

declare(strict_types=1);

require_once 'controller/UserActions.php';

try {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
    $userActions = new UserActions();

    $response = $id !== null ? $userActions->getUserById($id) : $userActions->getUsers();

    header('Content-Type: application/json');
    echo json_encode($response, JSON_THROW_ON_ERROR);
} catch (Exception $e) {

    $error_response = [
        'success' => false,
        'message' => 'Error mostrando alumno/s: ' . $e->getMessage(),
        'data' => []
    ];

    header('Content-Type: application/json');
    echo json_encode($error_response, JSON_THROW_ON_ERROR);
}