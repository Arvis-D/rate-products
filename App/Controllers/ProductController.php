<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Services\ProductService;
use App\Views\View;

class ProductController
{
    use \App\Traits\RedirectTrait;
    use \App\Traits\SessionMessageTrait;

    private $product;
    private $productService;

    public function __construct(
        ProductModel $product,
        ProductService $productService
        ) {
        $this->product = $product;
        $this->productService = $productService;
    }

    public function index()
    {
        View::get('Pages\Products')->set([
            'products' => '$this->product->getAll()'
        ])->show();
    }

    public function delete()
    {

    }

    public function create()
    {
        View::get('Pages\CreateProduct')->show();
    }

    public function store()
    {
        $errors = $this->productService->validateProduct($_POST);
        $this->setMessage('productErrors', $errors);
        if (empty($errors)) {
        
        } else {
            print_r($errors);
            die();
            $this->setMessage('inputErrors', $errors);
            $this->setMessage('inputOld', $_POST);
            $this->redirect('/product/add');
        }
    }
}