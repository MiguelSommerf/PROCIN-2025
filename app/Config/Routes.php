<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('src', function (RouteCollection $routes){
    $routes->post('cadastrar', 'LoginController::cadastrarUsuario');
    $routes->post('login', 'LoginController::logarUsuario');
    $routes->post('carrinho', 'CarrinhoController::carrinho');
    $routes->post('pagamento', 'PagamentoController::gerarTransacao');
});

$routes->resource('produtos', ['controller' => 'ProdutosController']);
