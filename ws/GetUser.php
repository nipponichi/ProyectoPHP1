<?php

declare(strict_types=1);

require_once 'models/Connection.php';
require_once 'models/User.php';

class GetUser
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getUserById(string $id): mixed
    {
        $pdo = $this->connection->getPDO();
        $sql = "SELECT * FROM alumno WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $user_data = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($user_data)) {

            $birth_date = new \DateTime($user_data['fecha_nacimiento']);

            $user = new User(
                $user_data['id'],
                $user_data['nombre'],
                $user_data['apellidos'],
                $user_data['password'],
                $user_data['telefono']?? '',
                $user_data['email']?? '',
                $user_data['sexo']?? '',
                $birth_date,
                $user_data['how_meet_us']?? '',
                $user_data['privacy_policy'] ? true : false,
                $user_data['newsletter'] ? true : false
            );
            return $user;
        }

        return null;

    }

    public function getUsers(): mixed
    {
        $pdo = $this->connection->getPDO();
        $sql = "SELECT * FROM alumno";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $users_data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        if (!empty($users_data)) {
            foreach ($users_data as $user_data) {

                $birth_date = new \DateTime($user_data['fecha_nacimiento']);

                $user = new User(
                    $user_data['id'],
                    $user_data['nombre'],
                    $user_data['apellidos'],
                    $user_data['password'],
                    $user_data['telefono'] ?? '',
                    $user_data['email'] ?? '',
                    $user_data['sexo'] ?? '',
                    $birth_date,
                    $user_data['how_meet_us'] ?? '',
                    $user_data['privacy_policy'] ? true : false,
                    $user_data['newsletter'] ? true : false,
                );

                $users[] = $user;
            }
            return $users;
        }
        return null;
    }

}