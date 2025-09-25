<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentoVendedorModel extends Model
{
    protected $table            = 'tb_documento_vendedor';
    protected $primaryKey       = 'id_documento_vendedor';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_documento', 'id_vendedor', 'documento_vendedor'];

    public function inserirDocumentoVendedor(array $dadosVendedor): bool
    {
        $idPais = (int)$dadosVendedor['pais_vendedor'];
        $tipoDocumento = (int)$dadosVendedor['tipo_documento'];

        $documentoModel = new DocumentoModel();
        $documento = $documentoModel->retornarDocumento($tipoDocumento, $idPais);

        if (!empty($documento)) {
            $documentoVendedor = [
                'id_vendedor'        => $dadosVendedor['id_vendedor'],
                'id_documento'       => $documento['id_documento'],
                'documento_vendedor' => trim($dadosVendedor['documento_vendedor'])
            ];

            if ($this->insert($documentoVendedor)) {
                return true;
            }

            return false;
        }

        return false;
    }
}
