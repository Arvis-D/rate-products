<?php

namespace App\Repository;

interface UserRepositoryInterface
{
    public function addUser(string $username, string $email, string $password): int;

    public function getIdAndPassword(string $username): ?array;

    public function getId(string $username): ?int;

    /**
     * @return array all data in user table except the password
     */

    public function getData(int $id): ?array;

    public function update(
        int $userId,
        string $username, 
        string $email, 
        string $password = null,
        string $avatar = null
    ): void;

    public function getPassword(int $id): ?string;

    public function setAvatar(int $id, string $url): void;
}
