<?php

namespace App\Repository;

use App\Helper\MySQLDatabase;

class LikeRepository
{
    private $db;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $likeTable example: product_picture, product_comment, shop_comment etc
     */

    public function insertLike(string $likeTable, int $subjectId, int $userId, bool $like): void
    {
        $this->db->sql(
            "INSERT INTO {$likeTable} VALUES (null, :si, {$userId}, {(int) $like});",
            ['si' => $subjectId]
        );
    }
}
