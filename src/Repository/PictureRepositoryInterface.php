<?php

namespace App\Repository;

use App\Model\Picture\PictureFull;
use App\Repository\LikeRepositoryInterface;

interface PictureRepositoryInterface extends SubjectInterface
{
    public function addPicture(int $subjectId, string $pictureUrl, int $userId): int;

    public function removePicture(string $criteria, $value);

    public function getPicture(int $id, ?int $userId): array;

    /**
     * @return picture added by user
     */

    public function getUserPicture(int $subjectId, int $userId): array;

    //public function getPictureUrlByUserId(int $userId);

    /**
     * @return array<PictureThumbnail>
     */

    public function getPictures(int $subjectId): array;

    public function getLikeRepository(): LikeRepositoryInterface;
}
