<?php

namespace App\Models;

use CodeIgniter\Model;

class VendedorModel extends Model
{
    protected $table            = 'tb_vendedor';
    protected $primaryKey       = 'id_vendedor';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nome_vendedor', 'email_vendedor', 'senha_vendedor', 'nascimento_vendedor'];

    public function inserirVendedor(array $vendedor): bool
    {
        $vendedor['nome_vendedor'] = ucfirst(trim($vendedor['nome_vendedor']));
        $vendedor['email_vendedor'] = trim(strtolower($vendedor['email_vendedor']));
        $vendedor['senha_vendedor'] = password_hash($vendedor['senha_vendedor'], PASSWORD_DEFAULT);
        $vendedor['nascimento_vendedor'] = date('Y-m-d', strtotime($vendedor['nascimento_vendedor']));

        if ($this->insert($vendedor)) {
            $idVendedor = $this->select('id_vendedor')->where('email_vendedor', $vendedor['email_vendedor'])->first();
            $documentoVendedor = [
                'id_vendedor'        => (int)$idVendedor['id_vendedor'],
                'pais_vendedor'      => $vendedor['pais_vendedor'],
                'tipo_documento'     => $vendedor['tipo_documento'],
                'documento_vendedor' => $vendedor['documento_vendedor']
            ];
            
            $documentoVendedorModel = new DocumentoVendedorModel();
            $completarCadastro = $documentoVendedorModel->inserirDocumentoVendedor($documentoVendedor);

            if ($completarCadastro) {
                return true;
            }

            $this->where('id_vendedor', $idVendedor['id_vendedor'])->delete();

            return false;
        };

        return false;
    }

    public function verificarSenhaVendedor(array $vendedor, string $senhaVendedor): bool
    {
        $dadosVendedor = $this->retornarDadosVendedor($vendedor['email_vendedor']);

        if (password_verify($senhaVendedor, $dadosVendedor['senha_vendedor'])) {
            return true;
        }

        return false;
    }

    public function retornarDadosVendedor(string $emailVendedor): array|bool
    {
        $dadosVendedor = $this->where('email_vendedor', $emailVendedor)->first();

        if (!empty($dadosVendedor)) {
            $dadosVendedor = [
                'id_vendedor'    => $dadosVendedor['id_vendedor'],
                'email_vendedor' => $dadosVendedor['email_vendedor'],
                'senha_vendedor' => $dadosVendedor['senha_vendedor']
            ];

            return $dadosVendedor;
        }

        return false;
    }
}
