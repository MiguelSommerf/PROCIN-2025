<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class LoginController extends BaseController
{
    use ResponseTrait;
    
    public function cadastrarUsuario(): ResponseInterface
    {
        $request = $_POST;
        $validation = \Config\Services::validation();

        $rules = [
            'nome_usuario'       => 'required|min_length[3]|max_length[50]',
            'email_usuario'      => 'required|valid_email|max_length[255]|is_unique[tb_usuario.email_usuario]',
            'senha_usuario'      => 'required|min_length[8]',
            'nascimento_usuario' => 'required'
        ];

        // Por conta da língua, essas mensagens podem ir para um outro arquivo futuramente.
        $messages = [
            'nome_usuario' => [
                'required'   => 'O nome de usuário é obrigatório.',
                'min_length' => 'O nome de usuário precisa conter no mínimo 3 caracteres.',
                'max_length' => 'O nome de usuário pode conter no máximo 50 caracteres.'
            ],

            'email_usuario' => [
                'required'    => 'O endereço de e-mail é obrigatório.',
                'valid_email' => 'O endereço de e-mail precisa ser válido.',
                'max_length'  => 'O endereço de e-mail pode conter no máximo 255 caracteres.',
                'is_unique'   => 'O endereço de e-mail inserido já está cadastrado.'
            ],

            'senha_usuario' => [
                'required'   => 'O campo senha é obrigatório.',
                'min_length' => 'O campo senha precisa conter no mínimo 8 caracteres.'
            ],

            'nascimento_usuario' => [
                'required' => 'A data de nascimento é obrigatória.'
            ]
        ];

        if (!$validation->setRules($rules, $messages)->run($request)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $userModel = new UserModel();
        
        if ($userModel->inserirUsuario($request)) {
            return $this->respondCreated(true);
        }

        return $this->failValidationErrors($userModel->errors());
    }

    public function logarUsuario(): ResponseInterface
    {
        $request = $_POST;
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
            return $this->failValidationErrors($validation->getErrors());
        }
        
        $userModel = new UserModel();
        $login = $userModel->verificarSenha($request, $request['senha_usuario']);

        if ($login) {
            return $this->respondCreated(true);
        }

        return $this->respondCreated(false);
    }
}
