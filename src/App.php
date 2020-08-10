<?php

namespace App;

use App\Factory\Provider;

class App
{
    public function start()
    {
        Provider::$recipes = include __DIR__ . '/Config/recipes.php';
        include __DIR__ . '/Router/routes.php';
    }
}