<?php

namespace App\Service\Product;

use App\Service\Validate\ValidationService;
use App\Service\Validate\ValidationResourceInterface;

class ProductValidationService extends ValidationService
{
    public function __construct(ValidationResourceInterface $resource)
    {
        $this->setResource($resource);
    }

    private function getTranslations()
    {
        return [
            'price.numeric' => 'Price has to be a numeric!',
            'price.numericSize' => 'Price has to be a positive number!',
            'name.required' => 'Product name is required!',
            'name.unique' => 'Such product already exists!',
            'rating.numeric' => 'Rating has to be a numeric!',
            'rating.numericSize' => 'Rating has to be between 0 and 5!',
            'comment.length' => 'Comments may not be longer than 500 characters'
        ];
    }

    public function validateProductCreation(array $params): array
    {
        return $this->setValues($params)
            ->key('name')->required()->unique('product.name')
            ->key('price')->optional()->numeric(0)
            ->key('rating')->optional()->numeric(0, 5)
            ->key('comment')->optional()->len(0, 500)
            ->translateErrors($this->getTranslations())->getErrors();
    }
}
