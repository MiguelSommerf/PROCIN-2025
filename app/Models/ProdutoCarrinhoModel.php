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

    public function adicionarProdutoCarrinho($idUsuario, $idProduto, $precoProduto): bool
    {
        $carrinho = new CarrinhoModel();
        $idCarrinho = $carrinho->encontrarCarrinho($idUsuario);

        if ($this->where('id_carrinho', $idCarrinho)->select()) {
            $produtoQtd = (int)$this->where('id_produto', $idProduto)->select('quantidade_produto');
            $produtoQtd++;
            
            if (!$this->where('id_produto', $idProduto)->select('preco_produto')) {
                $this->insert($precoProduto);
            }

            return true;
        }

        return false;
    }
}
