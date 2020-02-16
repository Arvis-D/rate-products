<?php

namespace App\Services;

use App\Models\Database;
use App\Factory;

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

        $attributes = (array)json_decode($productData['attributes']);
        $attributesToValidate = [];
        
        switch ($productData['type']) {
            case 'book':
                $attributesToValidate = [
                    'weight' => ['required', 'numeric']
                ];
                break;
            case 'cd':
                $attributesToValidate = [
                    'size' => ['required', 'numeric']
                ];
                break;
            case 'furniture':
                $attributesToValidate = [
                    'height' => ['required', 'numeric'],
                    'width' => ['required', 'numeric'],
                    'length' => ['required', 'numeric']
                ];
                break;
            default;
                die('no such type exits');
        }

        $attributeErrors = $this->validate($attributes, $attributesToValidate);

        return array_merge($errors, $attributeErrors);
    }

    public static function getInst($name = 'basic')
    {
        return Factory::make($name, self::class, function () {
            return new ProductService(Database::getInst());
        });
    }
}