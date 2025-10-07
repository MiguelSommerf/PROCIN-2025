<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class JWTController extends BaseController
{
    public function gerarJWT($id, $email): string
    {
        $payload = [
            'iat' => time(),
            'exp' => time() + 1800,
            'data' => [
                'id'    => (int)$id,
                'email' => $email
            ]
        ];

        $secret = 'teste';
        $token = JWT::encode($payload, $secret, 'HS256');

        return $token;
    }

    public function atualizarToken ($jwt = false, $refreshToken = false): void
    {
    }
}
