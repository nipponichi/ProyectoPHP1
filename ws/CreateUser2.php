<?php

declare(strict_types=1);

require_once 'models/Connection.php';
require_once 'models/User.php';

class createUser2
{
    private Connection $connection;

    private PDO $pdo;
    public function __construct()
    {
        $this->connection = new Connection();
        $this->pdo = $this->connection->getPDO();
    }

    public function createUser(): mixed
    {
        try {
            $query = "INSERT INTO alumno (nombre, apellidos, fecha_nacimiento, password, privacy_policy)
                  VALUES (:nombre, :apellidos, :fecha_nacimiento, :password, :privacy_policy)";
            $statement = $this->pdo->prepare($query);

            $nombre = 'Juana';
            $apellidos = 'Gutierrez';
            $fecha_nacimiento = '1976-12-19';
            $password = '1234';
            $privacy_policy = true;

            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':apellidos', $apellidos);
            $statement->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $statement->bindParam(':password', $password);
            $statement->bindParam(':privacy_policy', $privacy_policy);

            $statement->execute();

            $user_id = $this->pdo->lastInsertId();

            return [
                'id' => $user_id,
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'fecha_nacimiento' => $fecha_nacimiento,
                'password' => $password,
                'privacy_policy' => $privacy_policy
            ];

        } catch (PDOException $e) {
            throw new Exception('Error al crear alumno: ' . $e->getMessage());
        }
    }

    public function request()
    {
        try {

            $new_user = $this->createUser();

            $response = [
                'success' => true,
                'message' => 'Alumno creado correctamente',
                'data' => $new_user,
            ];

            header('Content-Type: application/json');
            $response_json = json_encode($response, JSON_THROW_ON_ERROR);
            print_r($response_json);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
            header('Content-Type: application/json');
            $response_json = json_encode($response, JSON_THROW_ON_ERROR);
            print_r($response_json);
        }
    }

}

$createUser2 = new CreateUser2();
$createUser2->request();





