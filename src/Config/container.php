<?php

use App\Helper\Csrf;
use App\Mediator\Listener\AuthSubscriber;
use App\Service\Auth\JwtAuthService;

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
    $dispatcher->addSubscriber(new AuthSubscriber($c['JwtAuthService']));
    return $dispatcher;
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

/**
 * Services
 */

$container['AuthValidationService'] = function ($c) {
    return new \App\Service\Validate\AuthValidationService($c['DbValidationResource']);
};

$container['JwtAuthService'] = function ($c) {
    return new JwtAuthService($c['UserRepository'], $c['AuthValidationService'], $c['session']);
};

 /**
  * DB related
  */

$container['mysql'] = function ($c) {
    return new \App\Repository\MySQLDatabase(
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

/**
 * Other
 */

$container['view'] = function ($c) {
  return new \App\Helper\View($c['twig'], $c['dispatcher']);
};
$container['csrf'] = function () {
    return new Csrf(new \Symfony\Component\Security\Csrf\CsrfTokenManager());
};

return $container;