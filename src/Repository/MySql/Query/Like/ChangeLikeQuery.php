<?php

namespace App\Repository\MySql\Query\Like;

use App\Helper\MySql\QueryInterface;

class ChangeLikeQuery implements QueryInterface
{
    private $id;
    private $table;
    private $like;

    public function __construct(string $table, int $id, bool $like)
    {
        $this->table = $table;
        $this->id = $id;
        $this->like = (int) $like;
    }

    public function getQuery(): string
    {
        return 
        "UPDATE {$this->table}
        SET like_or_dislike = :like
        WHERE id = :id;";
    }

    public function getParams(): array
    {
        return [
            'id' => $this->id,
            'like' => $this->like
        ];
    }
}
