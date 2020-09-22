<?php

namespace App\Controller;

use App\Helper\View;
use App\Repository\ProductRepository;
use App\Service\Auth\AuthServiceInterface;
use App\Service\Product\ProductService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductPictureController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(Request $request, View $view)
    {
        $id = $this->productService->uploadPicture($request->files->get('image'), $request->get('product-id'));
        sleep(5);

        return new Response($view->render('elements/pictureUpload', [
            'picture' => ['id' => $id],
            'imageAdded' => true
        ]));
    }
}
