<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use CodeIgniter\HTTP\ResponseInterface;
use Codeigniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function cadastrar(): ResponseInterface
    {
        $request = $this->request->getJSON(true);
        $validation = \Config\Services::validation();

        $qtdRequest = count($request);

        if ($qtdRequest <= 4) {
            $request['tipo_conta'] = 0;
        }

        switch ($request['tipo_conta']) {
            case 1:
                $rules = [
                    'nome_usuario'       => 'required|min_length[3]|max_length[50]',
                    'email_usuario'      => 'required|valid_email|max_length[255]|is_unique[tb_usuario.email_usuario]|is_unique[tb_vendedor.email_vendedor]|is_unique[tb_loja.email_loja]',
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
                            'id_usuario'    => (int)$idUsuario,
                            'email_usuario' => $emailUsuario
                        ]
                    ];

                    $secret = 'teste'; // Por enquanto, essa é a secret para testes. Entretanto, terá uma secret que não ficará disponível no github
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
                $rules = [
                    'nome_vendedor'       => 'required|min_length[3]|max_length[50]',
                    'email_vendedor'      => 'required|valid_email|max_length[255]|is_unique[tb_vendedor.email_vendedor]|is_unique[tb_usuario.email_usuario]|is_unique[tb_loja.email_loja]',
                    'senha_vendedor'      => 'required|min_length[8]',
                    'nascimento_vendedor' => 'required',
                    'pais_vendedor'       => 'required',
                    'tipo_documento'      => 'required',
                    'documento_vendedor'  => 'required|max_length[255]'
                ];

                $messages = [
                    'nome_vendedor' => [
                        'required'   => 'O nome de usuário é obrigatório.',
                        'min_length' => 'O nome de usuário precisa conter no mínimo 3 caracteres.',
                        'max_length' => 'O nome de usuário pode conter no máximo 50 caracteres.'
                    ],

                    'email_vendedor' => [
                        'required'    => 'O endereço de e-mail é obrigatório.',
                        'valid_email' => 'O endereço de e-mail precisa ser válido.',
                        'max_length'  => 'O endereço de e-mail pode conter no máximo 255 caracteres.',
                        'is_unique'   => 'O endereço de e-mail inserido já está cadastrado.'
                    ],

                    'senha_vendedor' => [
                        'required'   => 'O campo senha é obrigatório.',
                        'min_length' => 'O campo senha precisa conter no mínimo 8 caracteres.'
                    ],

                    'nascimento_vendedor' => [
                        'required' => 'A data de nascimento é obrigatória.'
                    ],

                    'pais_vendedor' => [
                        'required' => 'Você precisa selecionar um país.'
                    ],

                    'tipo_documento' => [
                        'required' => 'Você precisa selecionar um tipo de documento.'
                    ],

                    'documento_vendedor' => [
                        'required'   => 'O campo documento é obrigatório.',
                        'max_length' => 'O campo documento não pode ultrapassar os 255 caracteres.'
                    ],
                ];

                if (!$validation->setRules($rules, $messages)->run($request)) {
                    return $this->failValidationErrors($validation->getErrors());
                }

                $vendedorController = new VendedorController();

                if ($vendedorController->cadastrarVendedor($request)) {
                    $emailVendedor = trim(strtolower($request['email_vendedor']));
                    $dadosVendedor = $vendedorController->retornarVendedor($emailVendedor);
                    $idVendedor = $dadosVendedor['id_vendedor'];

                    $payload = [
                        'iat'  => time(),
                        'exp'  => time() + 3600,
                        'data' => [
                            'id_vendedor' => (int)$idVendedor,
                            'email_vendedor' => $emailVendedor,
                        ]
                    ];

                    $secret = "teste";
                    $jwt = JWT::encode($payload, $secret, 'HS256');

                    return $this->response->setJSON([
                        'status' => 'success',
                        'jwt'    => $jwt
                    ]);
                }

                return $this->response->setJSON([
                    'status'   => false,
                    'mensagem' => 'Ocorreu um erro ao cadastrar. Tente novamente.'
                ]);
            case 3:
                return $this->response->setJSON([
                    'status'   => false,
                    'mensagem' => 'O cadastro de loja ainda não está disponível.'
                ]);
            default:
                return $this->response->setJSON([
                    'status' => false,
                    'mensagem' => 'O tipo de conta é necessário para cadastrar.'
                ]);
        }
    }

    public function logar(): ResponseInterface
    {
        $request = $this->request->getJSON(true);
        $validation = \Config\Services::validation();

        $rules = [
            'email' => 'required|min_length[8]|max_length[255]',
            'senha' => 'required|min_length[8]|max_length[255]'
        ];

        $messages = [
            'email' => [
                'required'    => 'O endereço de e-mail é obrigatório.',
                'valid_email' => 'O endereço de e-mail precisa ser válido.',
                'max_length'  => 'O endereço de e-mail pode conter no máximo 255 caracteres.',
            ],

            'senha' => [
                'required'   => 'O campo senha é obrigatório.',
                'min_length' => 'O campo senha precisa conter no mínimo 8 caracteres.'
            ],
        ];

        if (!$validation->setRules($rules, $messages)->run($request)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $authModel = new AuthModel();
        $login = $authModel->logar($request['email'], $request['senha']);

        if (!empty($login)) {
            $payload = [
                'iat' => time(),
                'exp' => time() + 3600,
                'data' => $login
            ];

            $secret = 'teste';
            $jwt = JWT::encode($payload, $secret, 'HS256');

            return $this->response->setJSON([
                'status' => 'success',
                'jwt'    => $jwt
            ]);
        }

        return $this->response->setJSON([
            'status'   => false,
            'mensagem' => 'Usuário ou senha incorretos.'
        ]);
    }
}
