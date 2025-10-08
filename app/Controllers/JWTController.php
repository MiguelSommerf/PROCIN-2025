<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Firebase\JWT\JWT;

class JWTController extends BaseController
{
    public function gerarJWT($id, $email): array
    {
        $tokenPayload = [
            'iat'  => time(),
            'exp'  => time() + 1800,
            'data' => [
                'id'    => (int)$id,
                'email' => $email
            ]
        ];

        $refreshPayload = [
            'iat'  => time(),
            'exp'  => time() + 1209600,
            'data' => [
                'id'    => (int)$id,
                'email' => $email
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

    public function atualizarToken ($jwt = false, $refreshToken = false): void
    {
    }
}
