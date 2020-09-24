<?php

namespace App\Repository\Model\Product;

use App\Repository\Model\Picture\Picture;
use App\Repository\Model\Picture\PictureThumbnail;

class ProductPage extends ProductCard
{
    public Picture $picture;

    /**
     * @var array<PictureThumbnail> $pictures
     */

    public array $pictures;
}
