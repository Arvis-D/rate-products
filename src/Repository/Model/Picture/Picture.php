<?php

namespace App\Repository\Model\Picture;

use App\Repository\Model\Likes\Likes;
use App\Repository\Model\User\UserSmall;

class Picture extends PictureThumbnail
{
    public Likes $likes;
    public UserSmall $user;
    public string $timeElapsed;
}
