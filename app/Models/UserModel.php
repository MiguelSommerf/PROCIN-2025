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

    public function verificarSenha(array $request, string $senha): bool
    {
        $usuario = $this->retornarUsuario($request['email_usuario']);

        if ($usuario) {
            if (password_verify($senha, $usuario['senha_usuario'])) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function retornarUsuario($email): array|bool
    {
        $query = $this->where('email_usuario', $email)->first();

        if (!empty($query)) {
            $usuario = [
                'nome_usuario'  => $query['nome_usuario'],
                'email_usuario' => $query['email_usuario'],
                'senha_usuario' => $query['senha_usuario']
            ];

            return $usuario;
        }

        return false;
    }
}
