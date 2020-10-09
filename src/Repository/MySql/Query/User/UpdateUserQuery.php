<?php

namespace App\Repository\MySql\Query\User;

use App\Helper\MySql\QueryInterface;

class UpdateUserQuery implements QueryInterface
{   
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getParams(): array
    {
        return [];
    }

    public function getQuery(): string
    {
        return '';
    }
}
