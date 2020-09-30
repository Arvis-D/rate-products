<?php

namespace App\Service\Product;

use App\Helper\Time;
use App\Repository\ProductRepositoryInterface;
use App\Service\Auth\AuthServiceInterface;
use App\Service\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

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
        if (!$this->validationService->validateProductCreation($params)) {
            return false;
        };

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
}
