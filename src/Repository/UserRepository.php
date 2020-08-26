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

    public function createNewUser($username, $email, $password)
    {
        $this->db->stmt(
            'INSERT INTO user VALUES(NULL, :u, :e, :p);'
        , ['u' => $username, 'e' => $email, 'p' => $password]);
    }

    public function getPasswordByUserName($username): string
    {
        return $this->db->query(
            'SELECT password FROM user WHERE name = :u'
        , ['u' => $username])[0]['password'];
    }
}
