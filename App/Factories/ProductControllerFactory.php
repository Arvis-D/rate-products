<?php

namespace App\Factories;

use App\Controllers\ProductController;

class ProductControllerFactory extends Factory implements FactoryInterface
{
    public static $instances = [];

    public static function get($name = null)
    {
        return self::make($name, function () {
            return new ProductController(
                ProductFactory::get(),
                ProductServiceFactory::get()
            );
        });
    }
}