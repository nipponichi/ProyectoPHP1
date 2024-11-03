<?php

declare(strict_types=1);

require_once 'models/Connection.php';
require_once 'models/User.php';

class UserActions
{
    private Connection $connection;
    private PDO $pdo;
    private User $user;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->pdo = $this->connection->getPDO();
        $this->user = new User();
    }

    public function createUser(User $user): array
    {
        try {
            $query = "INSERT INTO alumno 
            (nombre, apellidos, password, telefono, email, sexo, 
            fecha_nacimiento, how_meet_us, privacy_policy, newsletter)
            VALUES (:nombre, :apellidos, :password, :telefono, :email, :sexo, 
            :fecha_nacimiento, :how_meet_us, :privacy_policy, :newsletter)";
            $statement = $this->pdo->prepare($query);
            $nombre = $user->getName();
            $apellidos = $user->getLastName();
            $password = $user->getPassword();
            $telefono = $user->getPhone();
            $email = $user->getEmail();
            $sexo = $user->getGender();
            $fecha_nacimiento = $user->getBirthDate();
            $how_meet_us = $user->getHowMeetUs();
            $privacy_policy = $user->getPrivatePolicy();
            $newsletter = $user->getNewsletter();

            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':apellidos', $apellidos);
            $statement->bindParam(':password', $password);
            $statement->bindParam(':telefono', $telefono);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':sexo', $sexo);
            $statement->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $statement->bindParam(':how_meet_us', $how_meet_us);
            $statement->bindParam(':privacy_policy', $privacy_policy, PDO::PARAM_BOOL);
            $statement->bindParam(':newsletter', $newsletter, PDO::PARAM_BOOL);

            $statement->execute();

            $user_id = $this->pdo->lastInsertId();

            $user->setId((int) $user_id);

            $user = $this->user->mountUser($user);

            return [
                'success' => true,
                'message' => 'Alumno creado correctamente',
                'data' => $user
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear alumno: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deleteUser(int $id): array
    {
        try {
            $response = $this->getUserById($id);
            if (empty($response)) {
                return [
                    'success' => false,
                    'message' => 'No se encontró ningún alumno con ID ' . $id,
                    'data' => null
                ];
            }

            $query = "DELETE FROM alumno WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id);

            $response = $this->getUserById((int) $id);

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return [
                        'success' => true,
                        'message' => 'Alumno eliminado correctamente',
                        'data' => $response['data']
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'No se encontró ningún alumno con ID ' . $id,
                        'data' => null
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al ejecutar la eliminación',
                    'data' => null
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error general: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function getUserById(int $id): array
    {
        try {
            $query = "SELECT * 
            FROM alumno 
            WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
            $user_data = $statement->fetch(PDO::FETCH_ASSOC);
            if (!empty($user_data)) {
                return [
                    'success' => true,
                    'message' => 'Alumno cargado correctamente',
                    'data' => $user_data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se encontró ningún alumno con ese ID',
                    'data' => []
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al cargar el alumno: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getUsers(): array
    {
        try {
            $query = "SELECT * 
            FROM alumno";
            $statement = $this->pdo->prepare($query);
            $statement->execute();
            $users_data = $statement->fetchAll(PDO::FETCH_ASSOC);

            $users = [];
            if (!empty($users_data)) {
                foreach ($users_data as $user_data) {
                    $users[] = $user_data;
                }
                return [
                    'success' => true,
                    'message' => 'Alumnos cargados correctamente',
                    'data' => $users
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se encontraron alumnos',
                    'data' => []
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al cargar los alumnos: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function updateUser(User $user): array
    {
        try {
            $set = [];
            $values = [];

            $userArray = [
                'nombre' => $user->getName(),
                'apellidos' => $user->getLastName(),
                'password' => $user->getPassword(),
                'telefono' => $user->getPhone(),
                'email' => $user->getEmail(),
                'sexo' => $user->getGender(),
                'fecha_nacimiento' => $user->getBirthDate(),
                'how_meet_us' => $user->getHowMeetUs(),
                'privacy_policy' => $user->getPrivatePolicy(),
                'newsletter' => $user->getNewsletter()
            ];

            foreach ($userArray as $key => $value) {
                if ($value !== null && $value !== '') {
                    $set[] = "$key = :$key";
                    $values[":$key"] = $value;
                }
            }

            if (empty($set)) {
                return [
                    'success' => false,
                    'message' => 'No se ha actualizado ningún valor',
                    'data' => null
                ];
            }

            $query = "UPDATE alumno SET " . implode(', ', $set) . " WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $values[':id'] = $user->getId();

            foreach ($values as $key => $value) {
                $statement->bindValue($key, $value, is_bool($value) ? PDO::PARAM_BOOL : PDO::PARAM_STR);
            }

            if ($statement->execute()) {
                $user_data = $this->user->mountUser($user);

                return [
                    'success' => true,
                    'message' => 'Alumno actualizado correctamente',
                    'data' => $user_data
                ];

            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar',
                    'data' => null
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }


}