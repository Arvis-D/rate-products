<?php

namespace App\Repository\MySql;

use App\Helper\MySql\Database;
use App\Helper\MySql\Query;
use App\Helper\MySql\SimpleQuery;
use App\Repository\MySql\Query\User\UpdateUserQuery;
use App\Repository\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->setTable('user');
    }

    public function addUser(string $username, string $email, string $password, string $avatarUrl = null): int
    {
        $time = time();
        $query = $this->table->insert([$username, $email, $password, $time, $time, $avatarUrl]);
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

    public function getData(int $id): ?array
    {
        $user = $this->db->read($this->table->select(['*'], ['id' => $id]));

        return (empty($user) ? null : $user[0]);
    }

    public function getPassword(int $id): ?string
    {
        $password = $this->table->select(['password'], ['id' => $id]);

        return (empty($password) ? null : $password[0]);
    }

    public function update(array $data): void
    {
        $this->db->write(new UpdateUserQuery($data));
    }

    public function setAvatar(int $id, string $url): void
    {
        $this->db->write(new Query('UPDATE user SET avatar_url = :url WHERE id = :id;', [
            'id' => $id, 'url' => $url
        ]));
    }
}
