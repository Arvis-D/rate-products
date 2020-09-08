<?php

namespace App\Service\Product;

use App\Repository\ProductRepository;
use App\Service\Auth\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductService
{
    private $validationService;
    private $repository;
    private $session;
    private $auth;

    public function __construct(
        ProductValidationService $validationService,
        ProductRepository $repository, 
        Session $session,
        AuthServiceInterface $auth
        ) {
        $this->validationService = $validationService;
        $this->repository = $repository;
        $this->session = $session;
        $this->auth = $auth;
    }

    public function tryCreateNewProduct(array $params): bool
    {
        if (!empty($errors = $this->validationService->validateProductCreation($params))) {
            $this->session->getFlashBag()->set('errors', $errors);
            return false;
        }

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

    public function getProducts()
    {
        $products = $this->repository->getProductsWithBasicInfo();

        return $products;
    }

    public function getProduct(int $id)
    {
        return $this->repository->fetchProducInfo($id);
    }
}
