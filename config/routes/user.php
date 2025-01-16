<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('user_profile', '/profile')
        ->controller([App\Controller\UserController::class, 'profile'])
        ->methods(['GET']);

    $routes->add('user_reservations', '/reservations')
        ->controller([App\Controller\UserController::class, 'reservations'])
        ->methods(['GET']);
};