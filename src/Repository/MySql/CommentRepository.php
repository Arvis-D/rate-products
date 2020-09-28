<?php

namespace App\Repository\MySql;

use App\Helper\MySql\Database;
use App\Repository\CommentRepositoryInterface;

class CommentRepository extends AbstractRepository implements CommentRepositoryInterface
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->postfix = '_comment';
    }

    public function addComment(int $subjectId, string $commentContent, int $userId): int
    {
        $time = time();
        $this->write($this->table->insert([$subjectId, $userId, $commentContent, $time, $time]));

        return $this->db->pdo->lastInsertId();
    }
}
