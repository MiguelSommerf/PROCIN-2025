<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentoModel extends Model
{
    protected $table            = 'tb_documento';
    protected $primaryKey       = 'id_documento';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_pais', 'nome_documento'];

    public function retornarDocumento(int $idDocumento, int $idPais): array|bool
    {
        $dadosDocumento = $this->where(['id_documento' => $idDocumento, 'id_pais' => $idPais])->first();

        if (!empty($dadosDocumento)) {
            return $dadosDocumento;
        }

        return false;
    }
}
