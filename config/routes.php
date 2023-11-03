<?php
// config/routes.php
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('client_prenom', '/client/prenom/{prenom}')
        ->controller('App\Controller\ClientController::info')
        ->methods(['GET', 'HEAD'])
        ->requirements(['prenom' => '[a-zA-Z]+(?:-[a-zA-Z]+)*']);
};
