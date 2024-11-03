<?php

declare(strict_types=1);

require_once 'controller/UserActions.php';

try {

    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

    if ($id === null) {
        $response = [
            'success' => false,
            'message' => 'Debes proporcionar un ID',
            'data' => null,
        ];

        header('Content-Type: application/json');
        echo $json_response = json_encode($response, JSON_THROW_ON_ERROR);
    }

    $userActions = new UserActions();
    $response = $userActions->deleteUser($id);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_THROW_ON_ERROR);
} catch (Exception $e) {

    $error_response = [
        'success' => false,
        'message' => 'Error al eliminar alumno: ' . $e->getMessage(),
        'data' => []
    ];

    header('Content-Type: application/json');
    echo json_encode($error_response, JSON_THROW_ON_ERROR);
}








