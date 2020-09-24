<?php

namespace App\Repository;

interface LikeRepositoryInterface
{
    public function like(int $subjectId, bool $like, int $userID): int;

    public function getUserLike(int $userID): bool;

    /**
     * @return array number of likes and dislikes for the specified subject
     */

    public function getLikes(int $subjectId): array;

    public function removeLike(int $userId);

    public function setSubject(string $subject);
}
