<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('auth', function (RouteCollection $routes){
    $routes->post('cadastrar', 'AuthController::cadastrar');
    $routes->post('login', 'AuthController::logar');

    $routes->group('google', function (RouteCollection $routes) {
        $routes->get('url','GoogleAuth::googleUrl');
        $routes->get('callback', 'GoogleAuth::googleCallback');
    });
});

$routes->group('usuario', function (RouteCollection $routes) {
    $routes->post('carrinho', 'CarrinhoController::carrinho');
    $routes->post('pagamento', 'PagamentoController::gerarTransacao');
});

$routes->group('vendedor', function (RouteCollection $routes) {
    $routes->post('atribuir', 'VendedorProdutoController::atribuirProduto');
    $routes->get('listar/(:num)', 'VendedorProdutoController::listarProdutos/$1');
    $routes->delete('deletar', 'VendedorProdutoController::removerProduto');
});

$routes->group('produtos', function (RouteCollection $routes) {
    $routes->get('selecionarProduto/(:num)', 'ProdutosController::selecionarProduto/$1');
});