<?php

namespace App\Factories;

use App\Models\Database;
use App\Config\DatabaseConfig;

class DatabaseFactory extends Factory implements FactoryInterface
{
    public static $instances = [];

    public static function get($name = null)
    {
        return self::make($name, function () {
            return new Database(
                DatabaseConfig::HOST,
                DatabaseConfig::NAME,
                DatabaseConfig::USERNAME,
                DatabaseConfig::PASSWORD
            );
        });
    }
}