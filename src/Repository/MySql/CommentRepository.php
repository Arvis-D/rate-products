<?php

namespace App\Repository\MySql;

use App\Helper\MySQLDatabase;
use App\Repository\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    private $db;
    private $subject;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function addComment(int $subjectId, string $commentContent, int $userId): int
    {
        $time = time();
        $this->db->write("INSERT INTO {$this->subject}_comment VALUES(null, {$subjectId}, {$userId}, :c, {$time}, {$time});", [
            'c' => $commentContent
        ]);

        return $this->db->pdo->lastInsertId();
    }
}
