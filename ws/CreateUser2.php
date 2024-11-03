<?php

declare(strict_types=1);

require_once 'models/User.php';
require_once 'controller/UserActions.php';

$user = new User();

try {
    //Data from form
    $user_data = [
        'nombre' => $_POST['nombre'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'password' => $_POST['password'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'email' => $_POST['email'] ?? '',
        'sexo' => $_POST['sexo'] ?? '',
        'how_meet_us' => $_POST['how_meet_us'] ?? '',
        'privacy_policy' => isset($_POST['privacy_policy']) ? (bool)$_POST['privacy_policy'] : false,
        'newsletter' => isset($_POST['newsletter']) ? (bool)$_POST['newsletter'] : false,
    ];

    $errors = $user->validateForm($user_data, true);

    if (!empty($errors)) {
        $error_response = [
            'success' => false,
            'message' => 'Revisa los campos del formulario:',
            'data' => $errors
        ];
        header('Content-Type: application/json');
        echo json_encode($error_response, JSON_THROW_ON_ERROR);
        return;
    }

    $user->mountUserFromArray($user_data);

    $userActions = new UserActions();
    $response = $userActions->createUser($user);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_THROW_ON_ERROR);

} catch (Exception $e) {
    
    $error_response = [
        'success' => false,
        'message' => 'Error al crear alumno: ' . $e->getMessage(),
        'data' => []
    ];

    header('Content-Type: application/json');
    echo json_encode($error_response, JSON_THROW_ON_ERROR);
}
