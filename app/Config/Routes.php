<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('src', function (RouteCollection $routes){
    $routes->group('usuario', function (RouteCollection $routes) {
        $routes->post('cadastrar', 'LoginController::cadastrarUsuario');
        $routes->post('login', 'LoginController::logarUsuario');
        $routes->post('carrinho', 'CarrinhoController::carrinho');
        $routes->post('pagamento', 'PagamentoController::gerarTransacao');
    });

    $routes->group('vendedor', function (RouteCollection $routes) {
        $routes->post('cadastrar', 'VendedorController::cadastrarVendedor');
        $routes->post('login', 'VendedorController::logarVendedor');
    });

    $routes->group('produtos', function (RouteCollection $routes) {
        $routes->get('selecionarProduto/(:num)', 'ProdutosController::selecionarProduto/$1');
    });

    $routes->group('vendedor/produto', function (RouteCollection $routes) {
        $routes->post('atribuir', 'VendedorProdutoController::atribuirProduto');
        $routes->get('listar/(:num)', 'VendedorProdutoController::listarProdutos/$1');
        $routes->delete('deletar', 'VendedorProdutoController::removerProduto');
    });
});

// Sugestão: acredito que seria melhor agrupar todas as rotas de produto para um maior controle.
$routes->resource('produtos', ['controller' => 'ProdutosController']);
