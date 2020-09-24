<?php

namespace App\Repository;

use App\Repository\LikeRepositoryInterface;

interface PictureRepositoryInterface
{
    public function addPicture(int $subjectId, string $pictureUrl, int $userId): int;

    public function removePicture(int $id);

    public function getPicture(int $id): array;

    //public function getPictureUrlByUserId(int $userId);

    public function getPictures(int $subjectId): array;

    public function setSubject(string $subject);

    public function getLikeRepository(): LikeRepositoryInterface;
}
