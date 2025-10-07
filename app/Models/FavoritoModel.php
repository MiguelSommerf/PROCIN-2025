<?php

namespace App\Models;
use CodeIgniter\Model;

class FavoritoModel extends Model
{
    protected $table = 'tb_favorito';
    protected $primaryKey = 'id_favorito';
    protected $allowedFields = ['id_usuario', 'id_produto'];

    public function adicionarFavorito($idUsuario, $idProduto)
    {
        if (!$this->jaFavoritou($idUsuario, $idProduto)) {
            return $this->insert([
                'id_usuario' => $idUsuario,
                'id_produto' => $idProduto
            ]);
        }
        return false;
    }

    public function removerFavorito($idUsuario, $idProduto)
    {
        return $this->where('id_usuario', $idUsuario)
                    ->where('id_produto', $idProduto)
                    ->delete();
    }

    public function jaFavoritou($idUsuario, $idProduto)
    {
        return $this->where('id_usuario', $idUsuario)
                    ->where('id_produto', $idProduto)
                    ->first();
    }

    public function listarFavoritos($idUsuario)
    {
        return $this->select('tb_produto.*')
                    ->join('tb_produto', 'tb_produto.id_produto = tb_favorito.id_produto')
                    ->where('tb_favorito.id_usuario', $idUsuario)
                    ->findAll();
    }
}
