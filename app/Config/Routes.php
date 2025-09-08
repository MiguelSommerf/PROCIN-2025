<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('usuario', function (RouteCollection $routes){
    $routes->post('cadastrar', 'UserController::cadastrarUsuario');
    $routes->get('listar/(:num)', 'UserController::listarUsuario/$1');
});
