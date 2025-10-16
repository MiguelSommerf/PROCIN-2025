<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JWTModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\ResponseTrait;
use Firebase\JWT\JWT;

class JWTController extends BaseController
{
    use ResponseTrait;
    
    protected $jwtModel;

    public function __construct()
    {
        $this->jwtModel = new JWTModel();
    }

    public function gerarJWT($id, $email): array
    {
        $tokenPayload = [
            'iat'  => time(),
            'exp'  => time() + 1800,
            'data' => [
                'id'        => (int)$id,
                'email'     => $email
            ]
        ];

        $refreshPayload = [
            'iat'  => time(),
            'exp'  => time() + 1209600,
            'data' => [
                'id'        => (int)$id,
                'email'     => $email
            ]
        ];

        $secret = 'teste';
        $token = JWT::encode($tokenPayload, $secret, 'HS256');
        $refreshToken = JWT::encode($refreshPayload, $secret, 'HS256');

        $jwt = [
            'token'   => $token,
            'refresh' => $refreshToken,
        ];

        return $jwt;
    }

    public function atualizarToken(): ResponseInterface|bool
    {
        $request = $this->request->getJSON(true);
        $refreshToken = $request['refresh_token'];

        if (!empty($refreshToken)) {
            $dados = $this->jwtModel->verificarRefreshToken($refreshToken);

            if ($dados['refreshToken']) {
                $tokenPayload = [
                    'iat'  => time(),
                    'exp'  => time() + 3600,
                    'data' => [
                        'id'        => $dados['id'],
                        'email'     => $dados['email']
                    ]
                ];

                $secret = 'teste';
                $accessToken = JWT::encode($tokenPayload, $secret, 'HS256');
                $this->jwtModel->authModel->atualizarCliente($dados['tipoConta'], $dados['id'], ['token'], [$accessToken]);

                return $this->response->setJSON([
                    'status' => 'success',
                    'jwt'    => [
                        'token' => $accessToken
                    ]
                ]);
            }

            return $this->response->setJSON([
                'status'   => false,
                'mensagem' => 'Token incorreto ou expirado.'
            ]);
        }

        return false;
    }
}
