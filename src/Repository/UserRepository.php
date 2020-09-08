<?php

namespace App\Repository;

use App\Repository\MySQLDatabase;

class UserRepository
{
    private $db;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }

    public function createNewUser(string $username, string $email, string $password): int
    {
        $time = time();
        $this->db->sql(
            "INSERT INTO user VALUES(NULL, :u, :e, :p, {$time}, {$time});"
        , ['u' => $username, 'e' => $email, 'p' => $password]);

        return (int) $this->db->pdo->lastInsertId();
    }

    public function getPasswordIdByUsername(string $username): ?array
    {
        $results = $this->db->sqlFetch(
            'SELECT password, id FROM user WHERE name = :u'
        , ['u' => $username]);
        
        return (empty($results) ? null : $results[0]);
    }

    public function getIdByUsername(string $username): ?string
    {
        $id = $this->db->sqlFetch(
            'SELECT id FROM user WHERE name = :u'
        , ['u' => $username]);
        
        return (empty($id) ? null : $id[0]['id']);
    }
}
