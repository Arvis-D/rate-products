<?php

namespace App\Repository\MySql;

use App\Helper\MySql\Database;
use App\Helper\MySql\SimpleQuery;
use App\Model\Picture\PictureFull;
use App\Repository\PictureRepositoryInterface;
use App\Repository\LikeRepositoryInterface;
use App\Repository\Model\Picture\Picture;
use App\Repository\MySql\Query\Picture\PictureFullQuery;
use App\Repository\UserRepositoryInterface;

class PictureRepository extends AbstractRepository implements PictureRepositoryInterface
{
    private $user;
    private $like;

    public function __construct(
        Database $db, 
        LikeRepositoryInterface $like,
        UserRepositoryInterface $user
    ) {
        parent::__construct($db);
        $this->like = $like;
        $this->user = $user;
        $this->postFix = '_picture';
    }

    public function getLikeRepository(): LikeRepositoryInterface
    {
        $this->like->setSubject($this->tableName);

        return $this->like;
    }

    public function addPicture(int $subjectId, string $pictureUrl, int $userId): int
    {
        $time = time();
        $this->db->write(
            $this->table->insert([$subjectId, $userId, $pictureUrl, $time])
        );

        return $this->db->pdo->lastInsertId();
    }

    public function getPictures(int $subjectId): array
    {
        return $this->db->read(
            $this->table->select(['id', 'url'], [$this->subject . '_id' => $subjectId])
        );
    }

    public function getUserPictures(int $subjectId, int $userId): array
    {
        return $this->db->read(
            $this->table->select(['id', 'url'], [$this->subject . '_id' => $subjectId, 'user_id' => $userId])
        );
    }

    public function removePicture(string $criteria, $value)
    {
        $this->db->write($this->table->delete([$criteria => $value]));
    }

    public function getPicture(int $id, int $userId): array
    {
        $picture = $this->db->read(New PictureFullQuery($id, $this->tableName))[0];
        $likes = $this->getLikeRepository()->getLikes($id);
        $picture['userLike'] = $this->getLikeRepository()->getUserLike($id, $userId);

        return array_merge($picture, $likes);
    }

    public function pictureAdded(int $subjectId, int $userId): bool
    {
        return !empty($this->read($this->table->
            select(['COUNT(*) AS count'], ["{$this->subject}_id" => $subjectId, 'user_id' => $userId]
        )));
    }
}
