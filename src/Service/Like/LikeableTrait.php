<?php

namespace App\Service\Like;

use App\Repository\LikeRepositoryInterface;

trait LikeableTrait
{
    private function toggleLike(LikeRepositoryInterface $repository, bool $like, int $subjectId, int $userId)
    {
        if (null === $liked = $repository->getUserLike($subjectId, $userId)) {
            $repository->like($subjectId, $like, $userId);
        } else if((bool) $liked['like_or_dislike'] === $like) {
            $repository->removeLike('id', $liked['id']);
        } else {
            $repository->changeLike($liked['id'], $like);
        }
    }
}
