<?php

namespace App\Factories;

use App\Models\ProductModel;

class ProductModelFactory extends Factory implements FactoryInterface
{
    public static $instances = [];

    public static function get($name = null)
    {
        return self::make($name, function () {
            return new ProductModel(DatabaseFactory::get());
        });
    }
}