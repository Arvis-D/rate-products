<?php

namespace App\Service\Product;

use App\Repository\ProductRepository;
use App\Service\Auth\AuthServiceInterface;
use App\Service\ImageService;

class ProductService
{
    private $validationService;
    private $repository;
    private $auth;
    private $imageService;

    public function __construct(
        ProductValidationService $validationService,
        ProductRepository $repository, 
        AuthServiceInterface $auth,
        ImageService $imageService
        ) {
        $this->validationService = $validationService;
        $this->repository = $repository;
        $this->auth = $auth;
        $this->imageService = $imageService;
    }

    public function tryCreateNewProduct(array $params): bool
    {
        if (!$this->validationService->validateProductCreation($params)) {
            return false;
        };

        ['name' => $name, 'price' => $price, 'rating' => $rating, 'picture' => $picture] = $params;
        $userId = $this->auth->authParams()['id'];

        $productId = $this->repository->insertNewProduct($name, $userId);
        if (!empty($price)) 
            $this->repository->insertNewPrice($price, $productId, $userId);
        if (!empty($rating)) 
            $this->repository->insertNewRating($rating, $productId, $userId);
        if (!empty($picture)) 
            $this->repository->insertNewPicture($picture, $productId, $userId);
        if (!empty($comment)) 
            $this->repository->insertNewComment($comment, $productId, $userId);

        return true;
    }

    public function uploadPicture($file)
    {
        $this->image;
    }

    public function getProducts()
    {
        $products = $this->repository->getProductsWithBasicInfo();

        return $products;
    }

    public function getProduct(int $id)
    {
        $product = $this->repository->fetchProducInfo($id);
        $product['randomPicture'] = rand(0, count($product['pictures']) - 1);

        return $product;
    }
}
