<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_usuario';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome_usuario', 'email_usuario', 'senha_usuario', 'nascimento_usuario'];

    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    public function inserirUsuario(array $usuario): bool
    {
        if (!empty($usuario)) {
            $usuario['nome_usuario'] = trim(ucfirst($usuario['nome_usuario']));
            $usuario['email_usuario'] = trim(strtolower($usuario['email_usuario']));
            $usuario['senha_usuario'] = password_hash($usuario['senha_usuario'], PASSWORD_DEFAULT);

            $this->insert($usuario);
            
            return true;
        }
        
        return false;
    }

    public function retornarUsuario($id): array|bool
    {
        $data = $this->find($id);

        if (!empty($data)) {
            $usuario = [
                'nome_usuario'  => $data['nome_usuario'],
                'email_usuario' => $data['email_usuario']
            ];

            return $usuario;
        }

        return false;
    }
}
