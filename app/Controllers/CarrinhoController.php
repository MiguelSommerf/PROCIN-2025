<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarrinhoModel;
use App\Models\ProdutoCarrinhoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class CarrinhoController extends BaseController
{
    use ResponseTrait;
    public function carrinho(): ResponseInterface
    {
        $request = $this->request->getJSON(true);

        $carrinho = new CarrinhoModel();

        if (!$carrinho->encontrarCarrinho($request['id_usuario'])) {
            $carrinho->criarCarrinho($request['id_usuario']);
        }

        $produtoController = new ProdutosController();
        $dadosProduto = $produtoController->selecionarProduto($request['id_produto']);
        
        $produtoCarrinho = new ProdutoCarrinhoModel();

        if ($produtoCarrinho->adicionarProdutoCarrinho($request['id_usuario'], $dadosProduto['id_produto'], $request['quantidade_produto'])) {
            return $this->respondCreated(true);
        }

        return $this->failValidationErrors($produtoCarrinho->errors());
    }
}
