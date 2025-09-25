<?php

namespace App\Models;

use CodeIgniter\Model;

class PaisModel extends Model
{
    protected $table            = 'pais';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nome_pais'];

    public function retornarPais(int $idPais): array|bool
    {
        $dadosPais = $this->where('id_pais', $idPais)->first();

        if (!empty($dadosPais)) {
            return $dadosPais;
        }

        return false;
    }
}
