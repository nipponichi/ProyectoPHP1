<?php

declare(strict_types=1);

require_once '../ws/interfaces/IToJson.php';

class User implements IToJson
{
    private int $id;
    private string $name;
    private string $last_name;
    private string $password;
    private string $phone;
    private string $email;
    private string $gender;
    private string $birth_date;
    private string $how_meet_us;
    private bool $privacy_policy;
    private bool $newsletter;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $last_name = '',
        string $password = '',
        ?string $phone = '',
        ?string $email = '',
        ?string $gender = '',
        string $birth_date = '',
        ?string $how_meet_us = '',
        bool $privacy_policy = false,
        bool $newsletter = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->password = $password;
        $this->phone = $phone;
        $this->email = $email;
        $this->gender = $gender;
        $this->birth_date = $birth_date;
        $this->how_meet_us = $how_meet_us;
        $this->privacy_policy = $privacy_policy;
        $this->newsletter = $newsletter;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function getHowMeetUs()
    {
        return $this->how_meet_us;
    }

    public function getPrivatePolicy()
    {
        return $this->privacy_policy;
    }

    public function getNewsletter()
    {
        return $this->newsletter;
    }

    // Setters
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setBirthDate(string $birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    public function setHowMeet(string $how_meet_us): void
    {
        $this->how_meet_us = $how_meet_us;
    }

    public function setPolicy(bool $private_policy): void
    {
        $this->policy = $private_policy;
    }

    public function setNewsletter(bool $newsletter): void
    {
        $this->newsletter = $newsletter;
    }

    public function mountUser(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'last_name' => $user->getLastName(),
            'password' => $user->getPassword(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'gender' => $user->getGender(),
            'birth_date' => $user->getBirthDate(),
            'how_meet_us' => $user->getHowMeetUs(),
            'privacy_policy' => $user->getPrivatePolicy(),
            'newsletter' => $user->getNewsletter()
        ];
    }

    public function mountUserFromArray(array $data): User
    {
        if (!empty($data['id'])) {
            $this->id = $data['id'];
        }
        $this->name = $data['nombre'] ?? '';
        $this->last_name = $data['apellidos'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->phone = $data['telefono'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->gender = $data['sexo'] ?? '';
        $this->birth_date = $data['fecha_nacimiento'] ?? '';
        $this->how_meet_us = $data['how_meet_us'] ?? '';
        $this->privacy_policy = !empty($data['privacy_policy']) ? (bool) $data['privacy_policy'] : false;
        $this->newsletter = !empty($data['newsletter']) ? (bool) $data['newsletter'] : false;

        return $this;
    }

    // Converts user values to JSON
    public function toJson(): string
    {
        $user_values = [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'password' => $this->password,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'how_meet_us' => $this->how_meet_us,
            'privacy_policy' => $this->privacy_policy,
            'newsletter' => $this->newsletter
        ];

        return json_encode($user_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Checks form values
    function validateForm($user_data, $is_new_user): array
    {

        $errors = [];

        if (empty($user_data['nombre']) && $is_new_user) {
            $errors[] = 'El nombre es obligatorio';
        }

        if (empty($user_data['apellidos']) && $is_new_user) {
            $errors[] = 'Los apellidos son obligatorios';
        }

        if (empty($user_data['fecha_nacimiento']) && $is_new_user) {
            $errors[] = 'La fecha de nacimiento es obligatoria';
        }

        if (empty($user_data['password']) && $is_new_user) {
            $errors[] = 'La contraseña es obligatoria';
        } elseif (strlen($user_data['password']) < 8) {
            $errors[] = 'La contraseña debe tener al menos 8 caracteres';
        }

        if (empty($user_data['telefono']) && $is_new_user) {
            $errors[] = 'El teléfono es obligatorio';
        } elseif (!preg_match('/^\d{9}$/', $user_data['telefono'])) {
            $errors[] = 'El teléfono debe tener 9 números';
        }

        if (empty($user_data['email']) && $is_new_user) {
            $errors[] = 'El correo electrónico es obligatorio';
        } elseif (!filter_var($user_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El correo electrónico no es válido';
        }

        if (empty($user_data['sexo']) && $is_new_user) {
            $errors[] = 'El género es obligatorio';
        } elseif (!empty($user_data['sexo']) && (strlen($user_data['sexo']) > 1 || !in_array(strtoupper($user_data['sexo']), ['M', 'F', 'O']))) {
            $errors[] = 'El género debe ser M, F u O';
        }

        if (!$user_data['privacy_policy'] && $is_new_user) {
            $errors[] = 'Debe aceptar la política de privacidad';
        }

        return $errors;
    }
}
