<?php

$router->get('/', function($c) {
    return $c['HomeController']->index();
});