<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UsuarioController extends BaseController
{
    use ResponseTrait;
    
    public function cadastrarUsuario(array $request): bool
    {
        $userModel = new UserModel();
        
        if ($userModel->inserirUsuario($request)) {
            return true;
        }

        return false;
    }

    public function logarUsuario(array $request): ResponseInterface
    {
        $validation = \Config\Services::validation();

        $rules = [
            'email_usuario'      => 'required',
            'senha_usuario'      => 'required'
        ];

        $messages = [
            'email_usuario' => [
                'required'    => 'O endereço de e-mail é obrigatório.'
            ],

            'senha_usuario' => [
                'required'   => 'O campo senha é obrigatório.'
            ]
        ];

        if (!$validation->setRules($rules, $messages)->run($request)) {
            return $this->respondCreated($validation->getErrors());
        }
        
        $userModel = new UserModel();
        $login = $userModel->verificarSenha($request, $request['senha_usuario']);

        if ($login) {
            return $this->respondCreated(true);
        }

        return $this->respondCreated(false);
    }

    public function retornarUsuario($emailUsuario): array|bool
    {
        $userModel = new UserModel();
        $dadosUsuario = $userModel->retornarDadosUsuario($emailUsuario);

        if (!empty($dadosUsuario)) {
            return $dadosUsuario;
        }

        return false;
    }
}
