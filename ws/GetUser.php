<?php

declare(strict_types=1);

require_once 'models/Connection.php';
require_once 'models/User.php';

class GetUser
{
    private Connection $connection;
    private PDO $pdo;
    public function __construct()
    {
        $this->connection = new Connection();
        $this->pdo = $this->connection->getPDO();
    }

    public function getUserById(int $id): mixed
    {
        $query = "SELECT * FROM alumno WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $user_data = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($user_data)) {
            $user = $this->mountUser($user_data);
            return $user;
        }

        return null;
    }

    public function getUsers(): mixed
    {
        $query = "SELECT * FROM alumno";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $users_data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        if (!empty($users_data)) {
            foreach ($users_data as $user_data) {
                $user = $this->mountUser($user_data);
                $users[] = $user;
            }
            return $users;
        }
        return null;
    }

    private function mountUser(array $user_data): User
    {
        $birth_date = new \DateTime($user_data['fecha_nacimiento']);
        return new User(
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
    }

    public function request()
    {
        try {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            $users = $id !== null ? [$this->getUserById($id)] : $this->getUsers();

            $users_array = [];
            foreach ($users as $user) {
                if ($user !== null) {
                    $users_array[] = [
                        'id' => $user->getId(),
                        'name' => $user->getName(),
                        'last_name' => $user->getLastName(),
                        'phone' => $user->getPhone(),
                        'email' => $user->getEmail(),
                        'gender' => $user->getGender(),
                        'birth_date' => $user->getBirthDate() ? $user->getBirthDate()->format('Y-m-d') : null,
                        'how_meet_us' => $user->getHowMeetUs(),
                        'privacy_policy' => $user->getPrivatePolicy(),
                        'newsletter' => $user->getNewsletter()
                    ];
                }
            }

            $response = [
                'success' => true,
                'message' => 'Alumno/s cargado/s correctamente',
                'data' => $users_array
            ];
            header('Content-Type: application/json');
            $response_json = json_encode($response, JSON_THROW_ON_ERROR);
            print_r($response_json);
        } catch (Exception $e) {
            return 'Error al realizar la consulta: ' . $e->getMessage();
        }
    }


}

$getUser = new GetUser();
$getUser->request();





