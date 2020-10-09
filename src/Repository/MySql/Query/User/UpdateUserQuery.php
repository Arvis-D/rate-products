<?php

namespace App\Repository\MySql\Query\User;

use App\Helper\MySql\QueryInterface;

class UpdateUserQuery implements QueryInterface
{   
    private $username;
    private $email;
    private $avatar;
    private $userId;
    private $password;
    private $params = [];
    private $query = '';

    public function __construct(
        int $userId,
        string $username, 
        string $email, 
        ?string $password = null, 
        ?string $avatar = null
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = $avatar;
        $this->userId = $userId;

        $this->init();
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    private function init()
    {
        $this->query = 'UPDATE user SET name = :usr, email = :email';
        $this->params = ['usr' => $this->username, 'email' => $this->email];

        if ($this->avatar !== null) {
            $this->addAvatar();
        }

        if ($this->password !== null) {
            $this->addPassword();
        }

        $this->query .= " WHERE id = {$this->userId};";
    }

    private function addPassword()
    {
        $this->query .= ', password = :pwd';
        $this->params['pwd'] = $this->password; 
    }

    private function addAvatar()
    {
        $this->query .= ', avatar_url = :url';
        $this->params['url'] = $this->avatar;
    }
}
