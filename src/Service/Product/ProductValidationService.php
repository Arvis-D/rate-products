<?php

namespace App\Service\Product;

use App\Service\Validate\ValidationResourceInterface;
use App\Service\Validate\Validator;
use App\Service\Validate\ValidatorFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductValidationService
{
    private $resource;
    private $session;
    private $errorTranslations = [
        'price.number' => 'Price has to be a numeric!',
        'price.min' => 'Price has to be a positive number!',
        'name.required' => 'Product name is required!',
        'name.unique' => 'Such product already exists!',
        'rating.number' => 'Rating has to be a numeric!',
        'rating.min' => 'Rating has to be between 0 and 5!',
        'rating.max' => 'Rating has to be between 0 and 5!',
        'comment.length' => 'Comments may not be longer than 500 characters',
        'image.file' => 'Image must be a file!',
        'image.type' => 'Image type must one of the following: png, jpeg, jpg!',
        'Image.size' => 'Image must not be larger than 1MB!'
    ];

    public function __construct(ValidationResourceInterface $resource, Session $session)
    {
        $this->session = $session;
        $this->resource = $resource;
    }

    public function validateProductCreation(array $params): bool
    {
        $validator = $this->getValidator()->setParams($params);
        $validator->string(true, 'name')->unique('product.name');
        $validator->number(false, 'price')->min(0);
        $validator->number(false, 'rating')->min(0)->max(5);
        $validator->string(false, 'comment')->length(0, 500);
        $validator->file(false, 'image');

        return $validator->isValid();
    }

    private function getValidator(): Validator
    {
        return ValidatorFactory::create()
            ->setSession($this->session)
            ->setValidationResource($this->resource)
            ->setTranslation($this->errorTranslations);
    }
}
