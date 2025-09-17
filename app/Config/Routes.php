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

    $routes->group('produtos', function (RouteCollection $routes) {
        $routes->get('selecionarProduto/(:num)', 'ProdutosController::selecionarProduto/$1');
    });
});

// Sugestão: acredito que seria melhor agrupar todas as rotas de produto para um maior controle.
$routes->resource('produtos', ['controller' => 'ProdutosController']);
