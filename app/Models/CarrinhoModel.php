<?php

namespace App\Models;

use App\Database\Migrations\Carrinho;
use CodeIgniter\Model;

class CarrinhoModel extends Model
{
    protected $table            = 'tb_carrinho';
    protected $primaryKey       = 'id_carrinho';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_usuario'];

    protected bool $allowEmptyInserts = false;
    
    public function criarCarrinho($idUsuario): void
    {
        if (!$this->where('id_usuario', $idUsuario)->find()) {
            $idUsuario = ["id_usuario" => $idUsuario];

            $this->insert($idUsuario);
        }
    }

    public function excluirCarrinho($idUsuario): void
    {
        if ($this->where('id_usuario', $idUsuario)->find()) {
            $idCarrinho = $this->where('id_usuario', $idUsuario)->find('id_carrinho');
            $this->where('id_carrinho', $idCarrinho)->delete();
        }
    }

    public function encontrarCarrinho($idUsuario): bool|array
    {
        $idCarrinho = $this->select('id_carrinho')->where('id_usuario', $idUsuario)->first();

        if (empty($idCarrinho)) {
            return false;
        }
        
        return $idCarrinho;
    }
}
