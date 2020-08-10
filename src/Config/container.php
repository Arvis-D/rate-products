<?php

$container = new Pimple\Container();
$container['twigLoader'] = function () {
    return new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
};
$container['twig'] = function ($c) {
    $cacheDir = __DIR__ . '/../templates/cache';
    return new \Twig\Environment($c['twigLoader'], [
        'cache' => false,
    ]);
};
$container['request'] = function () {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
};

$container['HomeController'] = function ($c) {
    return new \App\Controller\HomeController($c['twig']);
};

return $container;