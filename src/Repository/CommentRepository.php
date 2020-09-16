<?php

namespace App\Repository;

use App\Helper\MySQLDatabase;

class CommentRepository
{
    private $db;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }
}
