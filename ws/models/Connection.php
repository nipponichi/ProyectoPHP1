<?php

declare(strict_types=1);

require_once 'Config.php';

class Connection
{
    private PDO $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
                DB_USER,
                DB_PASSWORD,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
