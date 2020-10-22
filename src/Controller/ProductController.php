<?php

namespace App\Controller;

use App\Helper\View;
use App\Repository\ProductRepositoryInterface;
use App\Service\Product\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController
{
    public function create(View $view) 
    {
        return new Response($view->render('pages/addProduct'));
    }

    public function store(ProductService $productService, Request $request) 
    {
        if ($productService->tryCreateNewProduct($request->request->all(), $request->files->get('image'))) {
            return new RedirectResponse('/');
        }

        return new RedirectResponse('/product/create');
    }

    public function index(ProductService $productService, View $view)
    {
        return new Response($view->render('pages/products', [
            'products' => $productService->getProducts()
        ]));
    }

    public function show(ProductService $productService, View $view, $id) 
    {
        return new Response($view->render('pages/product', [
            'product' => $productService->getProduct($id)
        ]));
    }

    public function getTypes(string $wildcard, ProductRepositoryInterface $product)
    {
        return new JsonResponse($product->getTypes($wildcard));
    }

    public function saveStats(Request $request, ProductService $product)
    {
        return new JsonResponse(
            $product->savePriceAndRating(
                $request->get('id'),
                (empty($rating = $request->get('rating')) ? null : $rating),
                (empty($price = $request->get('price')) ? null : $price)
            )
        );
    }
}
