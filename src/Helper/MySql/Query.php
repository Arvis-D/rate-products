<?php

namespace App\Helper\MySql;

class Query implements QueryInterface
{
    private $query;
    private $params;

    public function __construct(string $query, array $params)
    {
        $this->query = $query;
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
