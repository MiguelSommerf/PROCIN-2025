<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoCarrinhoModel extends Model
{
    protected $table            = 'tb_produto_carrinho';
    protected $primaryKey       = 'id_produto_carrinho';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_carrinho', 'id_produto', 'quantidade_produto', 'preco_produto'];

    protected bool $allowEmptyInserts = false;

    public function adicionarProdutoCarrinho($idUsuario, $idProduto, int $quantidade): bool
    {
        $carrinhoModel = new CarrinhoModel();
        $idCarrinho = $carrinhoModel->encontrarCarrinho($idUsuario);
        $idCarrinho = $idCarrinho['id_carrinho'];

        if (!$this->verificarCarrinho($idCarrinho)) {
            $produtoModel = new ProdutoModel();
            $precoProduto = $produtoModel->select('preco_produto')->where('id_produto', $idProduto)->first();
            $dadosCarrinho = [
                'id_carrinho'           => $idCarrinho,
                'id_produto'            => $idProduto,
                'quantidade_produto'    => $quantidade,
                'preco_produto'         => $precoProduto['preco_produto']
            ];

            $this->insert($dadosCarrinho);

            return true;
        }

        if ($this->atualizarCarrinho($idCarrinho, $idProduto, $quantidade)) {
            return true;
        };

        return false;
    }

    public function atualizarCarrinho($idCarrinho, $idProduto, int $quantidade): bool
    {
        // Atualiza um produto que já está no carrinho
        if ($this->where('id_carrinho', $idCarrinho)->where('id_produto', $idProduto)->first()) {
            $quantidadeProduto = (int)$this->select('quantidade_produto')->where('id_produto', $idProduto)->first();

            if ($quantidade > 0 && $quantidade != $quantidadeProduto) {
                $this->where('id_produto', $idProduto)->update(['quantidade_produto' => $quantidade]);
                return true;
            }

            if ($quantidade < 1 || $quantidade !== $quantidadeProduto) {
                $this->where('id_carrinho', $idCarrinho)->delete();
                return true;
            }

            return false;
        }

        // Adiciona um novo produto
        $produtoModel = new ProdutoModel();
        $precoProduto = (int)$produtoModel->select('preco_produto')->where('id_produto', $idProduto)->first();
        $dadosProduto = [
            'id_carrinho' => $idCarrinho,
            'id_produto' => $idProduto,
            'quantidade_produto' => $quantidade,
            'preco_produto' => $precoProduto
        ];

        if ($this->insert($dadosProduto)) {
            return true;
        };

        return false;
    }

    public function verificarCarrinho($idCarrinho): bool
    {
        if ($this->where('id_carrinho', $idCarrinho)->first()) {
            return true;
        }

        return false;
    }
}
