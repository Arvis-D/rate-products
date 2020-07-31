<?php

use \App\Factory\Recipe;

return [
    \App\Controller\TestController::class => [
        Recipe::create()->inst(\App\Service\TestService::class)
    ],
    \App\Service\TestService::class => [
        Recipe::create()->inst(\App\Service\AnotherService::class)
    ]
];