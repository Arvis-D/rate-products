<?php

namespace App\Service\Product;

use App\Repository\ProductRepositoryInterface;
use App\Service\Auth\AuthServiceInterface;
use App\Service\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductService
{
    private $validationService;
    public $repository;
    private $auth;
    private $imageService;

    public function __construct(
        ProductValidationService $validationService,
        ProductRepositoryInterface $repository, 
        AuthServiceInterface $auth,
        ImageService $imageService
    ) {
        $this->validationService = $validationService;
        $this->repository = $repository;
        $this->auth = $auth;
        $this->imageService = $imageService;
    }

    public function tryCreateNewProduct(array $params, ?UploadedFile $file): bool
    {
        if (!$this->validationService->validateProductCreation($params, !empty($params['type-id']))) {
            return false;
        };

        $params['type-id'] = (empty($params['type-id']) ? $this->repository->addType($params['type']) : $params['type-id']);
        $params['price'] = round((float) $params['price'] * 100);

        $userId = $this->auth->authParams('id');
        $params['picture'] = ($file === null ? '' : $this->imageService->createSetOfImages($file, 'product', $userId));
        $this->repository->addProduct($params, $userId);

        return true;
    }

    public function createImage(UploadedFile $file)
    {
        $uid = $this->auth->authParams('id');

        return $this->imageService->createSetOfImages($file, 'product', $uid);
    }

    public function getProducts()
    {
        $products = $this->repository->getProductsBasic();

        return $products;
    }

    public function getProduct(int $id)
    {
        $product = $this->repository->getProductFull($id, $this->auth->authParams('id'));
        if (null !== $userId = $this->auth->authParams('id')) {
            $product['userPicture'] = $this->repository
                ->getPictureRepository()
                ->getUserPicture($id, $userId)[0] ?? null;
        }
        
        return $product;
    }

    public function savePriceAndRating(int $productId, ?int $rating, ?float $price): array
    {
        $info = [];

        if ($this->validationService->validateStatSaving(['rating' => $rating, 'price' => $price])) {
            $userId = $this->auth->authParams('id');

            if ($price !== null)
                $info['price'] = $this->updateOrAddPrice($userId, $productId, $price);

            if ($rating !== null)
                $info['rating'] = $this->updateOrAddRating($userId, $productId, $rating);

            $info['success'] = true;

            return $info;
        }

        $info['success'] = false;

        return $info;
    }

    private function updateOrAddPrice(int $userId, int $productId, float $price): array
    {
        $price = round($price * 100);

        if (null !== $old = $this->repository->getUserPrice($userId, $productId)) {
            $this->repository->updatePrice($userId, $productId, $price);

            return ['old' => $old, 'action' => 'updated'];
        } else {
            $this->repository->addPrice($productId, $userId, $price);

            return ['action' => 'added'];
        }
    }

    private function updateOrAddRating(int $userId, int $productId, int $rating): array
    {
        if (null !== $old = $this->repository->getUserRating($userId, $productId)) {
            $this->repository->updateRating($userId, $productId, $rating);

            return ['old' => $old, 'action' => 'updated'];
        } else {
            $this->repository->addRating($productId, $userId, $rating);

            return ['action' => 'added'];
        }
    }
}
