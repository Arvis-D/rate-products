<?php

$c = new Pimple\Container();

/**
 * Libraries
 */

$c['twigLoader'] = function () {
    return new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
};
$c['twig'] = function ($c) {
    $cache = ($_ENV['TWIG_CACHE'] === 'on') ? __DIR__ . '/../templates/cache' : false;
    $elapsed = new \Twig\TwigFilter('elapsed', [\App\Helper\Time::class, 'getElapsedTime']);
    $twig = new \Twig\Environment($c['twigLoader'], [
        'cache' => $cache,
    ]);
    $twig->addFilter($elapsed);

    return $twig;
};
$c['request'] = function () {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
};
$c['session'] = function () {
    $session = new \Symfony\Component\HttpFoundation\Session\Session();
    $session->start();
    return $session;
};
$c['dispatcher'] = function ($c) {
    $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher;
    $dispatcher->addSubscriber(new \App\Mediator\Listener\CsrfSubscriber($c['csrf']));
    $dispatcher->addSubscriber(new \App\Mediator\Listener\AuthSubscriber($c['JwtAuthService']));
    $dispatcher->addSubscriber(new \App\Mediator\Listener\SessionSubscriber($c['session']));
    return $dispatcher;
};
$c['EmailValidationService'] = function ($c) {
    
};

/**
 * Controllers
 */

$c['HomeController'] = function ($c) {
    return new \App\Controller\HomeController($c['view']);
};
$c['AuthController'] = function ($c) {
    return new \App\Controller\AuthController($c['JwtAuthService']);
};
$c['ProductController'] = function ($c) {
    return new \App\Controller\ProductController($c['ProductService']);
};
$c['ProductPictureController'] = function ($c) {
    return new \App\Controller\ProductPictureController($c['PictureService']);
};
$c['ApiValidationController'] = function ($c) {
    return new \App\Controller\ApiValidationController($c['DbValidationResource']);
};

/**
 * Services
 */

$c['AuthValidationService'] = function ($c) {
    return new \App\Service\Auth\AuthValidationService($c['DbValidationResource'], $c['session']);
};
$c['ProductValidationService'] = function ($c) {
    return new \App\Service\Product\ProductValidationService($c['DbValidationResource'], $c['session']);
};
$c['JwtAuthService'] = function ($c) {
    return new \App\Service\Auth\JwtAuthService($c['UserRepository'], $c['AuthValidationService']);
};
$c['ProductService'] = function ($c) {
    return new \App\Service\Product\ProductService(
        $c['ProductValidationService'], 
        $c['ProductRepository'],  
        $c['JwtAuthService'],
        $c['ImageService']
    );
};
$c['ImageService'] = function () {
    return new \App\Service\ImageService(new \Intervention\Image\ImageManager(['driver' => 'imagick']));
};
$c['PictureService'] = function ($c) {
    return new \App\Service\Picture\PictureService(
        $c['PictureRepository'],
        $c['PictureValidationService'],
        $c['JwtAuthService'],
        $c['ImageService']
    );
};
$c['PictureValidationService'] = function ($c) {
    return new \App\Service\Picture\PictureValidationService(
        $c['session'],
        $c['DbValidationResource']
    );
};

 /**
  * DB related
  */

$c['mysql'] = function ($c) {
    return new \App\Helper\MySql\Database(
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PWD']
    );
};

$c['DbValidationResource'] = function ($c) {
    return new \App\Service\Validate\DbValidationResource($c['mysql']);
};

$c['UserRepository'] = function ($c) {
    return new \App\Repository\MySql\UserRepository($c['mysql']);
};
$c['LikeRepository'] = function ($c) {
    return new \App\Repository\MySql\LikeRepository($c['mysql']);
};
$c['CommentRepository'] = function ($c) {
    return new \App\Repository\MySql\CommentRepository($c['mysql']);
};
$c['PictureRepository'] = function ($c) {
    return new \App\Repository\MySql\PictureRepository(
        $c['mysql'],
        $c['LikeRepository'],
        $c['UserRepository']
    );
};
$c['ProductRepository'] = function ($c) {
    return new \App\Repository\MySql\ProductRepository(
        $c['mysql'],
        $c['PictureRepository'],
        $c['CommentRepository'],
    );
};

/**
 * Other
 */

$c['view'] = function ($c) {
  return new \App\Helper\View($c['twig'], $c['dispatcher']);
};
$c['csrf'] = function () {
    return new \App\Helper\Csrf(new \Symfony\Component\Security\Csrf\CsrfTokenManager());
};
$c['router'] = function ($c) {
    $router = new \App\Router\Router(
        $c['request']->getPathInfo(),
        $c['request']->getRealMethod(),
        $c
    );
    $router->setAuth($c['JwtAuthService']);
    
    return $router;
};

return $c;