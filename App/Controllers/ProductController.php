<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Services\ProductService;
use App\Utilities\Redirect;
use App\Utilities\SessionMessage;
use App\Views\View;
use App\Factory;

class ProductController
{
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
            Redirect::to('/');
        } else {
            $attr = (array)json_decode($_POST['attributes']);
            SessionMessage::set('inputErrors', $errors);
            SessionMessage::set('inputOld', array_merge($attr, $_POST));
            Redirect::to('/product/add');
        }
    }

    public static function getInst($name = 'basic')
    {
        return Factory::make($name, self::class, function () {
            return new ProductController(
                ProductModel::getInst(),
                ProductService::getInst()
            );
        });
    }

}