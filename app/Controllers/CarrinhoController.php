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
        $request = $this->request->getJSON();

        $carrinho = new CarrinhoModel();

        if (!$carrinho->encontrarCarrinho($request['id_usuario'])) {
            $carrinho->criarCarrinho($request['id_usuario']);
        }

        $produtoController = new ProdutosController();
        $dadosProduto = null;

        $produtoCarrinho = new ProdutoCarrinhoModel();

        if ($produtoCarrinho->adicionarProdutoCarrinho($request['id_usuario'], $dadosProduto['id_produto'], $dadosProduto['preco_produto'])) {
            return $this->respondCreated(true);
        }

        return $this->failValidationErrors($produtoCarrinho->errors());
    }
}
