<?php

namespace App\Repository\Model\Product;

use App\Repository\Model\Picture\PictureThumbnail;

class ProductCard extends ProductSearch
{
    public int $rating;
    public int $price;
}
