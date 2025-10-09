<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function cadastrarUsuario(array $request): bool
    {
        if ($this->usuarioModel->inserirUsuario($request)) {
            return true;
        }

        return false;
    }

    public function atualizarUsuario($idUsuario, $campos, $dados): bool
    {
        if ($this->usuarioModel->atualizarUsuario($idUsuario, $campos, $dados)) {
            return true;
        }

        return false;
    }

    public function retornarUsuario($emailUsuario): array|bool
    {
        $dadosUsuario = $this->usuarioModel->retornarDadosUsuario($emailUsuario);

        if (!empty($dadosUsuario)) {
            return $dadosUsuario;
        }

        return false;
    }
}
