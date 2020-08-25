<?php

/**
 * Libraries
 */

$container = new Pimple\Container();
$container['twigLoader'] = function () {
    return new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
};
$container['twig'] = function ($c) {
    $cache = $_ENV['TWIG_CACHE'] ? __DIR__ . '/../templates/cache' : false;
    return new \Twig\Environment($c['twigLoader'], [
        'cache' => $cache,
    ]);
};
$container['request'] = function () {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
};
// $container['env'] = function () {
//     $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
//     $dotenv->load();
//     return $dotenv;
// };

/**
 * Controllers
 */

$container['HomeController'] = function ($c) {
    return new \App\Controller\HomeController($c['twig']);
};
$container['AuthController'] = function ($c) {
    return new \App\Controller\AuthController();
};

/**
 * Services
 */


 /**
  * Other
  */

return $container;