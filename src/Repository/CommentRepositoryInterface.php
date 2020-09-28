<?php

namespace App\Repository;

interface CommentRepositoryInterface extends SubjectInterface
{
    public function addComment(int $subjectId, string $commentContent, int $userId): int;
    
    public function setSubject(string $subject);
}
