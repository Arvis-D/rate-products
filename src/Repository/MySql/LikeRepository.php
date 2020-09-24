<?php

namespace App\Repository\MySql;

use App\Helper\MySQLDatabase;
use App\Repository\LikeRepositoryInterface;

class LikeRepository implements LikeRepositoryInterface
{
    private $db;
    private $subject = '';

    public function __construct(MySQLDatabase $db, string $subject = '')
    {
        $this->db = $db;
        $this->subject = $subject;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function like(int $subjectId, bool $like, int $userID): int
    {
        $this->db->write(
            "INSERT INTO {$this->subject}_like VALUES (null, :subject_id, {$userID}, {(int) $like});",
            ['subject_id' => $subjectId]
        );

        return $this->db->pdo->lastInsertId();
    }

    public function getUserLike(int $userID): bool
    {
        return (bool) $this->db->read(
            "SELECT like_or_dislike from {$this->subject}_like WHERE user_id = :id;",
            ['id' => $userID]
        )[0]['like_or_dislike'];
    }

    public function removeLike(int $userId)
    {
        $this->db->write(
            "DELETE FROM {$this->subject}_like WHERE user_id = :id",
            ['id' => $userId]
        );
    }

    public function getLikes(int $subjectId): array
    {
        $result = $this->db->read(
            "SELECT
                COUNT(*) as total,
                SUM(likes.like_or_dislike) as liked
            FROM {$this->subject}_like likes

            WHERE likes.{$this->subject}_id = :subId;",
            ['subId' => $subjectId]
        )[0];

        return [
            'likes' => (int) $result['liked'],
            'dislikes' => $result['total'] - $result['liked']
        ];
    }
}
