<?php

namespace App\Repository;

use App\Repository\PictureRepositoryInterface;

interface ProductRepositoryInterface
{
    public function addProduct(array $product, int $userId): int;

    public function getProductsBasic(): array;

    public function getProductFull(int $productId, ?int $userId): array;

    public function addPrice(int $productId, int $userId, int $price);

    public function addRating(int $productId, int $userId, int $rating);

    public function getPictureRepository(): PictureRepositoryInterface;

    public function getTypes(string $name): array;

    public function addType(string $name): int;

    public function updatePrice(int $userId, int $productId, int $price): void;

    public function updateRating(int $userId, int $productId, int $rating): void;

    public function getUserRating(int $userId, int $productId): ?int;

    public function getUserPrice(int $userId, int $productId): ?int;
}