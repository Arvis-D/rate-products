<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Services\ProductService;
use App\Views\View;

class ProductController
{
    use \App\Traits\RedirectTrait;
    use \App\Traits\SessionMessageTrait;

    private $productModel;
    private $productService;

    public function __construct(
        ProductModel $product,
        ProductService $productService
        ) {
        $this->productModel = $product;
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
        if (empty($errors)) {
            $this->productModel->create($_POST);
            $this->redirect('/');
        } else {
            $attr = (array)json_decode($_POST['attributes']);
            $this->setMessage('inputErrors', $errors);
            $this->setMessage('inputOld', array_merge($attr, $_POST));
            $this->redirect('/product/add');
        }
    }
}