<?php

namespace App\Repository;

use App\Model\Product\ProductFull;
use App\Repository\PictureRepositoryInterface;
use App\Model\Product\ProductCard;

interface ProductRepositoryInterface
{
    public function addProduct(array $product, int $userId): int;

    public function getProductsBasic(): array;

    public function getProductFull(int $productId, int $userId): array;

    public function addPrice(int $id, int $userId, int $price);

    public function addRating(int $id, int $userId, int $rating);

    public function getPictureRepository(): PictureRepositoryInterface;
}
