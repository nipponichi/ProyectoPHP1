<?php 

declare(strict_types=1);

require_once '../ws/models/User.php';

// html form values
$id = (int) ($_POST['id'] ?? '0');
$name = (string) ($_POST['name'] ?? 'noname');
$last_name = (string) ($_POST['last_name'] ?? 'noLastName');
$password_input = (string) ($_POST['password'] ?? '');
$phone = (string) ($_POST['phone'] ?? '654987321');
$email = (string) ($_POST['email'] ?? 'no@email.com');
$gender = (string) ($_POST['gender'] ?? 'other');
$birth_date_input = (string) ($_POST['birthday'] ?? '1900-01-01');
$how_meet_us = (string) ($_POST['how_meet_us'] ?? 'unknown');
$privacy_policy = (bool) ($_POST['privacy_policy'] === 1 ? true : false);
$newsletter = (bool) ($_POST['newsletter'] === 1 ? true : false);

// encrypt password 
$password = password_hash($password_input, PASSWORD_BCRYPT);

// Set string type date in datetime
$birth_date = new \DateTime($birth_date_input);

$user = new User(
    $id,
    $name, 
    $last_name, 
    $password, 
    $phone, 
    $email, 
    $gender, 
    $birth_date, 
    $how_meet_us, 
    $privacy_policy, 
    $newsletter
);

$user_json = $user->toJson();
$user->toTextFile($user_json);
echo $user_json;






