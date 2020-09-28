<?php

namespace App\Controller;

use App\Helper\View;
use App\Service\Picture\PictureService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductPictureController
{
    private $pictureService;

    public function __construct(PictureService $pictureService)
    {
        $this->pictureService = $pictureService;
        $this->pictureService->setSubject('product');
    }

    public function store(Request $request)
    {
        $id = $this->pictureService->uploadPicture($request->get('product-id'), $request->files->get('image'));

        return new JsonResponse([
            'id' => $id,
            'url' => $this->pictureService->getUploadedPath()
        ]);
    }

    public function delete(Request $request)
    {
        $this->pictureService->removePicture($request->get('picture-id'), $request->get('picture-url'));
    }

    public function like(Request $request)
    {
        $this->pictureService->like($request->get('subject-id'), (bool) $request->get('like'));

        return new Response();
    }

    public function show(int $id)
    {
        return new JsonResponse($this->pictureService->getPicture($id));
    }
}
