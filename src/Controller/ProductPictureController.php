<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Auth\AuthServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductPictureController
{
    private $repository;
    private $auth;

    public function __construct(ProductRepository $respository, AuthServiceInterface $auth)
    {
        $this->repository = $respository;
        $this->auth = $auth;
    }

    public function store(Request $request)
    {
        return new Response('success');
    }
}
