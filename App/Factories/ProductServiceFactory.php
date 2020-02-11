<?php

namespace App\Factories;

use App\Services\ProductService;

class ProductServiceFactory extends Factory implements FactoryInterface
{
    public static $instances = [];

    public static function get($name = null)
    {
        return self::make($name, function () {
            return new ProductService(DatabaseFactory::get());
        });
    }
}