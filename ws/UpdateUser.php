<?php

declare(strict_types=1);

require_once 'models/Connection.php';
require_once 'models/User.php';

class UpdateUser
{
    private Connection $connection;
    private PDO $pdo;
    public function __construct()
    {
        $this->connection = new Connection();
        $this->pdo = $this->connection->getPDO();
    }

    public function updateUser(int $id): void
    {
        $query = "UPDATE alumno
                SET nombre = :nombre,
                    apellidos = :apellidos,
                    fecha_nacimiento = :fecha_nacimiento,
                    password = :password,
                    privacy_policy =  :privacy_policy
                WHERE id = :id";
        $statement = $this->pdo->prepare($query);

        $nombre = 'Marina';
        $apellidos = 'Gutierrez';
        $fecha_nacimiento = '1976-12-19';
        $password = '1234';
        $privacy_policy = true;

        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':apellidos', $apellidos);
        $statement->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':privacy_policy', $privacy_policy);
        $statement->bindParam(':id', $id);

        $statement->execute();
    }

    public function request()
    {
        try {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
    
            if ($id === null) {
                $response = [
                    'success' => false,
                    'message' => 'Debes proporcionar un ID',
                    'data' => null,
                ];
                header('Content-Type: application/json');
                $json_response = json_encode($response, JSON_THROW_ON_ERROR);
                print_r($json_response);
                return;
            }
    
            $this->updateUser($id);
    
            $response = [
                'success' => true,
                'message' => 'Alumno modificado correctamente',
                'data' => null,
            ];
    
            header('Content-Type: application/json');
            echo json_encode($response, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage(),
                'data' => null,
            ];
            header('Content-Type: application/json');
            $json_response = json_encode($response, JSON_THROW_ON_ERROR);
            print_r($json_response);
        }
    }
}

$updateUser = new UpdateUser();
$updateUser->request();





