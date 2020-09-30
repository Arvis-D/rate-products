<?php

namespace App\Repository\MySql;

use App\Helper\MySql\Database;
use App\Repository\LikeRepositoryInterface;
use App\Repository\MySql\Query\Like\ChangeLikeQuery;

class LikeRepository extends AbstractRepository implements LikeRepositoryInterface
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->postFix = '_like';
    }

    public function like(int $subjectId, bool $like, int $userID): int
    {
        $this->db->write($this->table->insert([$subjectId, $userID, (int) $like]));

        return $this->db->pdo->lastInsertId();
    }

    public function get(string $criteria, $value): array
    {
        return $this->db->read($this->table->select(['like_or_dislike', 'id'], [$criteria => $value]))[0];
    }

    public function getUserLike(int $subjectId, int $userId): ?array
    {
        $like = $this->db->read($this->table->
            select(['like_or_dislike', 'id'], ['user_id' => $userId, "{$this->subject}_id" => $subjectId]
        ));

        if (empty($like)) {
            return null;
        } else {
            $like = $like[0];
            $like['like'] = ($like['like_or_dislike'] === '0' ? false : true);

            return $like;
        }
    }

    public function changeLike(int $likeId, bool $like)
    {
        $this->db->write(new ChangeLikeQuery($this->tableName, $likeId, $like));
    }

    public function removeLike(string $criteria, $value)
    {
        $this->db->write($this->table->delete([$criteria => $value]));
    }

    public function getLikes(int $subjectId): array
    {
        $result = $this->db->read( 
            $this->table->select(
                ['COUNT(*) AS total', 'SUM(like_or_dislike) as liked'],
                [$this->subject . '_id' => $subjectId]
        ))[0];

        return [
            'likes' => (int) $result['liked'],
            'dislikes' => $result['total'] - $result['liked']
        ];
    }
}
