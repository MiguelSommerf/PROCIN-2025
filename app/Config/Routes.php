<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('src', function (RouteCollection $routes){
    $routes->post('cadastrar', 'LoginController::cadastrarUsuario');
    $routes->post('login', 'LoginController::logarUsuario');
});
$routes->group('auth/google', function (RouteCollection $routes) {
    $routes->get('url','GoogleAuth::googleUrl');
    $routes->get('callback', 'GoogleAuth::googleCallback');
});

$routes->resource('produtos', ['controller' => 'ProdutosController']);
