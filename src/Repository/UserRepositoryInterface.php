<?php

namespace App\Repository;

interface UserRepositoryInterface
{
    public function addUser(string $username, string $email, string $password): int;

    public function getIdAndPassword(string $username): ?array;

    public function getId(string $username): ?int;
}
