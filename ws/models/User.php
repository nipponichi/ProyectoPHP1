<?php

declare(strict_types=1);

require_once 'ws/interfaces/IToJson.php';

class User implements IToJson 
{
    private int $id;
    private string $name;
    private string $last_name;
    private string $password;
    private string $phone;
    private string $email;
    private string $gender;
    private \DateTime $birth_date;
    private string $how_meet_us;
    private bool $privacy_policy;
    private bool $newsletter;

    public function __construct(
        int $id,
        string $name, 
        string $last_name, 
        string $password, 
        ?string $phone, 
        ?string $email, 
        ?string $gender, 
        \DateTime $birth_date, 
        ?string $how_meet_us, 
        bool $privacy_policy, 
        bool $newsletter
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
        public function setId(int $id) {
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
    
        public function setBirthDate(\DateTime $birth_date): void
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
            'birth_date' => $this->birth_date->format('d-m-Y'),
            'how_meet_us' => $this->how_meet_us,
            'privacy_policy' => $this->privacy_policy,
            'newsletter' => $this->newsletter
        ];

        return json_encode($user_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Save users in a txt file
    public function toTextFile(string $user_json): void
    {
        $file = fopen('UserList.txt','a');
        fwrite($file, $user_json);
        fclose($file);
    }
}
