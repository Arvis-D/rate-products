<?php

namespace App\Repository;

interface LikeRepositoryInterface extends SubjectInterface
{
    public function like(int $subjectId, bool $like, int $userID): int;

    public function get(string $criteria, $value): array;

    /**
     * @return array number of likes and dislikes for the specified subject
     */

    public function getLikes(int $subjectId): array;

    public function getUserLike(int $subjectId, int $userId): ?array;

    public function changeLike(int $likeId, bool $like);

    public function removeLike(string $criteria, $value);

    public function setSubject(string $subject);
}
