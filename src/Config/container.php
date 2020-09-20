<?php

$container = new Pimple\Container();

/**
 * Libraries
 */

$container['twigLoader'] = function () {
    return new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
};
$container['twig'] = function ($c) {
    $cache = ($_ENV['TWIG_CACHE'] === 'on') ? __DIR__ . '/../templates/cache' : false;
    return new \Twig\Environment($c['twigLoader'], [
        'cache' => $cache,
    ]);
};
$container['request'] = function () {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
};
$container['session'] = function () {
    $session = new \Symfony\Component\HttpFoundation\Session\Session();
    $session->start();
    return $session;
};
$container['dispatcher'] = function ($c) {
    $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher;
    $dispatcher->addSubscriber(new \App\Mediator\Listener\CsrfSubscriber($c['csrf']));
    $dispatcher->addSubscriber(new \App\Mediator\Listener\AuthSubscriber($c['JwtAuthService']));
    $dispatcher->addSubscriber(new \App\Mediator\Listener\SessionSubscriber($c['session']));
    return $dispatcher;
};
$container['EmailValidationService'] = function ($c) {
    
};

/**
 * Controllers
 */

$container['HomeController'] = function ($c) {
    return new \App\Controller\HomeController($c['view']);
};
$container['AuthController'] = function ($c) {
    return new \App\Controller\AuthController($c['JwtAuthService']);
};
$container['ProductController'] = function ($c) {
    return new \App\Controller\ProductController($c['ProductService']);
};
$container['ProductPictureController'] = function ($c) {
    return new \App\Controller\ProductPictureController($c['ProductService']);
};

/**
 * Services
 */

$container['AuthValidationService'] = function ($c) {
    return new \App\Service\Auth\AuthValidationService($c['DbValidationResource'], $c['session']);
};
$container['ProductValidationService'] = function ($c) {
    return new \App\Service\Product\ProductValidationService($c['DbValidationResource'], $c['session']);
};
$container['JwtAuthService'] = function ($c) {
    return new \App\Service\Auth\JwtAuthService($c['UserRepository'], $c['AuthValidationService']);
};
$container['ProductService'] = function ($c) {
    return new \App\Service\Product\ProductService(
        $c['ProductValidationService'], 
        $c['ProductRepository'],  
        $c['JwtAuthService'],
        $c['ImageService']
    );
};
$container['ImageService'] = function () {
    return new \App\Service\Image\ImageService(new \Intervention\Image\ImageManager(['driver' => 'imagick']));
};

 /**
  * DB related
  */

$container['mysql'] = function ($c) {
    return new \App\Helper\MySQLDatabase(
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PWD']
    );
};

$container['DbValidationResource'] = function ($c) {
    return new \App\Service\Validate\DbValidationResource($c['mysql']);
};

$container['UserRepository'] = function ($c) {
    return new \App\Repository\UserRepository($c['mysql']);
};
$container['ProductRepository'] = function ($c) {
    return new \App\Repository\ProductRepository($c['mysql']);
};

/**
 * Other
 */

$container['view'] = function ($c) {
  return new \App\Helper\View($c['twig'], $c['dispatcher']);
};
$container['csrf'] = function () {
    return new \App\Helper\Csrf(new \Symfony\Component\Security\Csrf\CsrfTokenManager());
};
$container['router'] = function ($c) {
    $router = new \App\Router\Router(
        $c['request']->getPathInfo(),
        $c['request']->getRealMethod(),
        $c
    );
    $router->setAuth($c['JwtAuthService']);
    
    return $router;
};
return $container;