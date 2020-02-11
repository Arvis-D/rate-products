<?php

namespace App\Services;

use App\Models\Database;

class ProductService extends ValidationService
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->table = 'products';
        $this->uniqueAttribute = 'sku';
    }

    public function validateProduct($productData)
    {
        $errors = $this->validate($productData, [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'sku' => ['required', 'unique'],
            'type' => ['required']
        ]);
        
        $attributes = $this->getAttributes($productData);
        $attrErrors = $this->validateTypeSpecific($attributes, $productData['type']);
        $errors = array_merge($errors, $attrErrors);
        return $errors;
    }

    private function validateTypeSpecific($data, $type)
    {
        $attributeErrors = [];
        switch($type){
            case 'Furniture':
                $attributeErrors = $this->validate($data, [
                    'height' => ['required', 'numeric'],
                    'length' => ['required', 'numeric'],
                    'width' => ['required', 'numeric'],
                ]);
            break;
            case 'CD':
                $attributeErrors = $this->validate($data, [
                    'size' => ['required', 'numeric'],
                ]);
            break;
            case 'Book':
                $attributeErrors = $this->validate($data, [
                    'weight' => ['required', 'numeric'],
                ]);
            break;
        }

        return $attributeErrors;
    }

    public function makePriceRight($price)
    {
        return number_format($price, 2);
    }

    public function getAttributes($productData)
    {
        return array_slice($productData, 5);
    }

}