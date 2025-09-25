<?php

namespace App\Models;

use CodeIgniter\Model;

class VendedorProdutoModel extends Model
{
    protected $table = 'tb_usuario_produto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'id_produto'];

    // aqui verirfico se tem vinculo com user
    public function existeVinculo($idUsuario, $idProduto)
    {
        return $this->where('id_usuario', $idUsuario)
                    ->where('id_produto', $idProduto)
                    ->first();
    }

    // lista os priodutos normal
    public function listarProdutosDoVendendor($idUsuario)
    {
        return $this->select('tb_produto.*')
                    ->join('tb_produto', 'tb_produto.id = tb_usuario_produto.id_produto')
                    ->where('tb_usuario_produto.id_usuario', $idUsuario)
                    ->findAll();
    }

    // remove o vinculo de user e produto
    public function removerVinculo($idUsuario, $idProduto)
    {
        return $this->where('id_usuario', $idUsuario)
                    ->where('id_produto', $idProduto)
                    ->delete();
    }
}
