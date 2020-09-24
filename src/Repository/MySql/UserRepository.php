<?php

namespace App\Repository\MySql;

use App\Helper\MySQLDatabase;
use App\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $db;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }

    public function addUser(string $username, string $email, string $password): int
    {
        $time = time();
        $this->db->write(
            "INSERT INTO user VALUES(NULL, :u, :e, :p, {$time}, {$time});"
        , ['u' => $username, 'e' => $email, 'p' => $password]);

        return (int) $this->db->pdo->lastInsertId();
    }

    public function getIdAndPassword(string $username): ?array
    {
        $results = $this->db->write(
            'SELECT password, id FROM user WHERE name = :u'
        , ['u' => $username]);
        
        return (empty($results) ? null : $results[0]);
    }

    public function getId(string $username): ?int
    {
        $id = $this->db->write(
            'SELECT id FROM user WHERE name = :u'
        , ['u' => $username]);
        
        return (empty($id) ? null : $id[0]['id']);
    }
}
