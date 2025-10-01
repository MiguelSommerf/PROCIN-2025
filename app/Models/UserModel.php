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

    public function inserirUsuario(array $usuario): bool
    {
        if (!empty($usuario)) {
            $usuario['nome_usuario'] = trim(ucfirst($usuario['nome_usuario']));
            $usuario['email_usuario'] = trim(strtolower($usuario['email_usuario']));
            $usuario['senha_usuario'] = password_hash($usuario['senha_usuario'], PASSWORD_DEFAULT);
            if ($usuario['nascimento_usuario'] != NULL) {
                $usuario['nascimento_usuario'] = date('Y-m-d', strtotime($usuario['nascimento_usuario']));
            }

            $this->insert($usuario);
            
            return true;
        }
        
        return false;
    }

    public function verificarSenha(array $request, string $senha): bool
    {
        $dadosUsuario = $this->retornarDadosUsuario($request['email_usuario']);

        if ($dadosUsuario) {
            if (password_verify($senha, $dadosUsuario['senha_usuario'])) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function retornarDadosUsuario($email): array|bool
    {
        $query = $this->where('email_usuario', $email)->first();

        if (!empty($query)) {
            $usuario = [
                'id_usuario'    => $query['id_usuario'],
                'email_usuario' => $query['email_usuario'],
                'senha_usuario' => $query['senha_usuario']
            ];

            return $usuario;
        }

        return false;
    }
}
