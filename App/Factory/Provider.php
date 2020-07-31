<?php

namespace App\Factory;

use App\Factory\Recipe;
use \Exception;

class Provider
{
    public static $recipes = [];

    public static function get(string $className, string $instanceName = 'basic')
    {
        if (Factory::exists($instanceName, $className)) {
            return Factory::$instances[$className][$instanceName];
        }

        if (!array_key_exists($className, self::$recipes)) {
            try {
                return Factory::make($className, function($class) {
                    return new $class;
                }, $instanceName);
            } catch (Exception $e) { }
        }

        $recipe = self::findRecipe($className, $instanceName);
        return self::createFromRecipe($recipe, $className, $instanceName);
    }

    private static function findRecipe($className, $name): ?Recipe
    {
        $arr = self::$recipes[$className];

        foreach ($arr as $key => $value) {

            
            if ($value->name === $name) {
                return $value;
            }
        }

        return null;
    }

    private static function createFromRecipe(Recipe $recipe, $className, $instanceName)
    {
        $readyDependencies = [];
        foreach ($recipe->dependencies as $dependency) {
            if (!$dependency['inst']) {
                array_push($readyDependencies, $dependency['value']);
            } else {
                array_push($readyDependencies, self::get($dependency['value']));
            }
        }

        return Factory::make($className, function ($class) use($readyDependencies) {
            return new $class(...$readyDependencies);
        }, $instanceName);
    }
}