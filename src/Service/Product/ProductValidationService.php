<?php

namespace App\Service\Product;

use App\Service\Picture\PictureValidationService;
use App\Service\Validate\ValidatorFactory;

class ProductValidationService
{
    public $validator;
    private $translations = [
        'price.number' => 'Price has to be a numeric!',
        'price.min' => 'Price has to be a positive number!',
        'name.required' => 'Product name is required!',
        'name.unique' => 'Such product already exists!',
        'rating.number' => 'Rating has to be a numeric!',
        'rating.min' => 'Rating has to be between 0 and 5!',
        'rating.max' => 'Rating has to be between 0 and 5!',
        'comment.length' => 'Comments may not be longer than 500 characters',
        'type.required' => 'Product type is required!',
        'type.unique' => 'Such type already exists'
    ];
    private $ratingMin = 0;
    private $ratingMax = 5;
    private $commentLength = 500;
    private $pictureValidator;

    public function __construct(ValidatorFactory $validatorFactory, PictureValidationService $pictureValidator)
    {  
        $this->pictureValidator = $pictureValidator;
        $this->validator = $validatorFactory->create($this->translations);
    }

    public function validateProductCreation(array $params, bool $typeAsId): bool
    {
        $validator = $this->validator->setParams($params);
        $validator->string(true, 'name')->unique('product.name');

        if (!$typeAsId) {
            $validator->string(true, 'type')->unique('product_type.name');
        } else {
            $validator->number(true, 'type-id')->exists('product_type.id');
        }

        $this->validatePrice();
        $this->validateRating();
        $validator->string(false, 'comment')->length(0, $this->commentLength);
        
        return ($validator->isValid() && $this->pictureValidator->validateImage(false));
    }

    public function validateStatSaving(array $params)
    {
        $this->validator->setParams($params);
        $this->validateRating();
        $this->validatePrice();

        return $this->validator->isValid();
    }

    private function validatePrice()
    {
        $this->validator->number(false, 'price')->min(0);
    }

    private function validateRating()
    {
        $this->validator->number(false, 'rating')->min($this->ratingMin)->max($this->ratingMax);
    }
}
