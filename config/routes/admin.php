<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('admin_dashboard', '/admin')
        ->controller([App\Controller\AdminController::class, 'index'])
        ->methods(['GET']);
};