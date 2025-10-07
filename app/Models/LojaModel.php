<?php


namespace App\Models;

use CodeIgniter\Model;

class LojaModel extends Model
{
    protected $table            = 'tb_loja';
    protected $primaryKey       = 'id_loja';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'email_loja',
        'senha_loja',
        'nome_loja',
        'especialidade_loja',
    ];

     // inserindo os campos de datas para informar ao banco certinho
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // validation rules novamente pra filtrar 
    protected $validationRules = [
        'email_loja' => 'required|valid_email|is_unique[tb_loja.email_loja]',
        'senha_loja' => 'required|min_length[6]',
        'nome_loja'  => 'required|min_length[3]',
        'especialidade_loja' => 'required',
    ];

    protected $validationMessages = [
        'email_loja' => [
            'is_unique' => 'Esse e-mail já está em uso.',
        ],
    ];

    protected $skipValidation = false;
}
