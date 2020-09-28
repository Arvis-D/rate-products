<?php

namespace App\Repository\MySql;

use App\Helper\MySql\Database;
use App\Helper\MySql\SimpleQuery;
use App\Repository\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->setTable('user');
    }

    public function addUser(string $username, string $email, string $password): int
    {
        $time = time();
        $query = $this->table->insert([$username, $email, $password, $time, $time]);
        $this->write($query);

        return (int) $this->db->pdo->lastInsertId();
    }

    public function getIdAndPassword(string $username): ?array
    {
        $results = $this->db->read($this->table->select(['id', 'password'], ['name' => $username]));
        
        return (empty($results) ? null : $results[0]);
    }

    public function getId(string $username): ?int
    {
        $id = $this->db->read( $this->table->select(['id'], ['name' => $username]))[0];
        
        return (empty($id) ? null : $id[0]['id']);
    }
}
