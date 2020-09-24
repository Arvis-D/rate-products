<?php

namespace App\Repository;

use App\Repository\PictureRepositoryInterface;

interface ProductRepositoryInterface
{
    public function addProduct(array $product, int $userId): int;

    public function getProductsBasic(): array;

    public function getProductFull(int $productId): array;

    public function addPrice(int $id, int $userId, int $price);

    public function addRating(int $id, int $userId, int $rating);

    public function getPictureRepository(): PictureRepositoryInterface;
}
