<?php

namespace App\Repository\MySql\Query\Picture;

use App\Helper\MySql\QueryInterface;

class PictureFullQuery implements QueryInterface
{
    private $id;
    private $table;

    public function __construct(int $id, string $table)
    {
        $this->table = $table;
        $this->id = $id;
    }

    public function getQuery(): string
    {
        return             
        
        "SELECT 
            pic.url,
            pic.time_created,
            pic.id,
            u.name as username
        FROM {$this->table} pic 
        INNER JOIN user u ON u.id = pic.user_id
        WHERE pic.id = :id;";
    }

    public function getParams(): array
    {
        return ['id' => $this->id];
    }
}
