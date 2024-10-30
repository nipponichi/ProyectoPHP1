<?php

declare(strict_types=1);

require_once 'models/Connection.php';
require_once 'models/User.php';

class DeleteUser
{
    private Connection $connection;
    private PDO $pdo;
    public function __construct()
    {
        $this->connection = new Connection();
        $this->pdo = $this->connection->getPDO();
    }

    public function deleteUser(int $id): void
    {
        $query = "DELETE FROM alumno WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
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

            $this->deleteUser($id);
            
            $response = [
                'success' => true,
                'message' => 'Alumno eliminado con éxito',
                'data' => null,
            ];

            header('Content-Type: application/json');
            $response_json = json_encode($response, JSON_THROW_ON_ERROR);
            print_r($response_json);
        } catch (Exception $e) {
            return 'Error al realizar la consulta: ' . $e->getMessage();
        }
    }

}

$deleteUser = new DeleteUser();
$deleteUser->request();





