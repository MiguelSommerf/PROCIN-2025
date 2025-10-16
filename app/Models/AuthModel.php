<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $usuarioModel;
    protected $vendedorModel;
    protected $lojaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->vendedorModel = new VendedorModel();
        $this->lojaModel = null;
    }

    public function retornarTipoLogin(string $email): int
    {
        $tipoConta = 0;

        if ($this->usuarioModel->retornarDadosUsuario($email)) {
            $tipoConta = 1;
        }

        if ($this->vendedorModel->retornarDadosVendedor($email)) {
            $tipoConta = 2;
        }

        if ($this->lojaModel) {
            $tipoConta = 3;
        }

        return $tipoConta;
    }

    public function logar(string $email, string $senha): array|bool
    {
        $tipoConta = $this->retornarTipoLogin($email);

        switch ($tipoConta) {
            case 1:
                $dadosUsuario = $this->usuarioModel->retornarDadosUsuario($email);
                $senhaUsuario = $dadosUsuario['senha_usuario'];

                if (password_verify($senha, $senhaUsuario)) {
                    $usuario = [
                        'id'    => $dadosUsuario['id_usuario'],
                        'email' => $dadosUsuario['email_usuario']
                    ];

                    return $usuario;
                }

                return false;
            case 2:
                $dadosVendedor = $this->vendedorModel->retornarDadosVendedor($email);
                $senhaVendedor = $dadosVendedor['senha_vendedor'];

                if (password_verify($senha, $senhaVendedor)) {
                    $vendedor = [
                        'id'    => $dadosVendedor['id_vendedor'],
                        'email' => $dadosVendedor['email_vendedor']
                    ];

                    return $vendedor;
                }

                return false;
            case 3:
                return false;
            default:
                return false;
        }
    }

    public function atualizarCliente($tipoConta, $id, array $campos, array $dados): bool
    {
        switch ($tipoConta) {
            case 1:
                $this->usuarioModel->atualizarUsuario($id, $campos, $dados);
                return true;
            case 2:
                $this->vendedorModel->atualizarVendedor($id, $campos, $dados);
                return true;
            case 3:
                return true;
        }

        return false;
    }
}
