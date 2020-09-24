<?php

namespace App\Repository\MySql;

use App\Repository\PictureRepositoryInterface;
use App\Helper\MySQLDatabase;
use App\Repository\LikeRepositoryInterface;
use App\Repository\Model\Picture\Picture;
use App\Repository\UserRepositoryInterface;

class PictureRepository implements PictureRepositoryInterface
{
    private $db;
    private $subject;
    private $user;
    public $like;

    public function __construct(
        MySQLDatabase $db, 
        LikeRepositoryInterface $like,
        UserRepositoryInterface $user
    ) {
        $this->db = $db;
        $this->like = $like;
        $this->user = $user;
    }

    public function getLikeRepository(): LikeRepositoryInterface
    {
        $this->like->setSubject('product_picture');

        return $this->like;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        $this->like->setSubject("{$subject}_picture");
    }

    public function addPicture(int $subjectId, string $pictureUrl, int $userId): int
    {
        $time = time();
        $this->db->write("INSERT INTO {$this->subject}_picture VALUES(null, {$subjectId}, {$userId}, :p, {$time});", [
            'p' => $pictureUrl
        ]);

        return $this->db->pdo->lastInsertId();
    }

    public function getPictures(int $subjectId): array
    {
        return $this->db->read(
            "SELECT id, url FROM {$this->subject}_picture WHERE {$this->subject}_id = :id"
        , ['id' => $subjectId]);
    }

    public function removePicture(int $id)
    {
        $this->db->write(
            "DELETE FROM {$this->subject}_picture WHERE id = :id"
        , ['id' => $id]);
    }

    public function getPicture(int $id): array
    {
        $raw = $this->db->read(
            "SELECT 
                pic.url,
                pic.time_created,
                pic.id,
                u.name as addedBy
            FROM {$this->subject}_picture pic 
            INNER JOIN user u ON u.id = pic.user_id
            WHERE pic.id = :id;
            ;"
        , ['id' => $id])[0];

        $likes = $this->like->getLikes($id);

        $picture = new Picture;
        $picture->id = $raw['id'];
        $picture->likes = $likes;

        return array_merge($raw, $likes);
    }
}
