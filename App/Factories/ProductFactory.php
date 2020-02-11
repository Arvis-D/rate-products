<?php

namespace App\Factories;

use App\Models\Product;

class ProductFactory extends Factory implements FactoryInterface
{
    public static $instances = [];

    public static function get($name = null)
    {
        return self::make($name, function () {
            return new Product(DatabaseFactory::get());
        });
    }
}