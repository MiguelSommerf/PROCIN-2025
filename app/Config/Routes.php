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
    $routes->post('usuario-produto/atribuir', 'UsuarioProdutoController::atribuirProduto');
    $routes->get('usuario-produto/listar/(:num)', 'UsuarioProdutoController::listarProdutos/$1');
    $routes->post('usuario-produto/remover', 'UsuarioProdutoController::removerProduto');
});

$routes->resource('produtos', ['controller' => 'ProdutosController']);
