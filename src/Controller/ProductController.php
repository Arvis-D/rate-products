<?php

namespace App\Controller;

use App\Helper\View;
use App\Repository\ProductRepository;
use App\Service\Product\ProductService;
use App\Service\Product\ProductValidationService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(View $view) 
    {
        return new Response($view->render('pages/addProduct'));
    }

    public function store(Request $request) 
    {
        if ($this->productService->tryCreateNewProduct($request->request->all())) {
            return new RedirectResponse('/');
        }

        return new RedirectResponse('/product/create');
    }

    public function index(View $view)
    {
        return new Response($view->render('pages/products', [
            'products' => $this->productService->getProducts()
        ]));
    }

    public function show(View $view, $id) 
    {
        return new Response($view->render('pages/product', [
            'product' => $this->productService->getProduct($id)
        ]));
    }
}
