<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Codeigniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends BaseController
{
    use ResponseTrait;

    public function cadastrar(): ResponseInterface
    {
        $request = $this->request->getJSON(true);
        $validation = \Config\Services::validation();

        switch ($request['tipo_conta']) {
            case 1:
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

                $usuarioController = new UsuarioController();

                if ($usuarioController->cadastrarUsuario($request)) {
                    $emailUsuario = trim(strtolower($request['email_usuario']));
                    $dadosUsuario = $usuarioController->retornarUsuario($emailUsuario);
                    $idUsuario = $dadosUsuario['id_usuario'];

                    $payload = [
                        'iat'  => time(), //issued at -> data de emissão
                        'exp'  => time() + 3600,
                        'data' => [
                            'id_usuario'    => $idUsuario,
                            'email_usuario' => $emailUsuario
                        ]
                    ];

                    $secret = 'teste';
                    $jwt = JWT::encode($payload, $secret, 'HS256');

                    return $this->response->setJSON([
                        'status' => 'success',
                        'jwt'    => $jwt
                    ]);
                }

                return $this->response->setJSON([
                    'status' => false,
                    'mensagem' => 'Ocorreu um erro ao cadastrar. Tente novamente.'
                ]);
            case 2:
                //vendedor
            break;
            case 3:
                //loja
            break;
            default:
            break;
        }
    }
}
