<?php

namespace App\Models;

use CodeIgniter\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTModel extends Model
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function verificarRefreshToken($refreshToken): array|bool
    {
        $secret = 'teste';
        $decodedToken = JWT::decode($refreshToken, new Key($secret, 'HS256'));

        if (time() < $decodedToken->exp) {
            $tipoConta = $this->authModel->retornarTipoLogin($decodedToken->data->email);

            switch ($tipoConta) {
                case 1:
                    $refreshTokenBanco = $this->authModel->usuarioModel->select('refresh_token')->where('id_usuario', $decodedToken->data->id)->first();

                    if ($refreshToken === $refreshTokenBanco['refresh_token']) {
                        return [
                            'id'           => $decodedToken->data->id,
                            'email'        => $decodedToken->data->email,
                            'refreshToken' => true,
                            'tipoConta'    => 1
                        ];
                    }

                    return [
                        'refreshToken' => false
                    ];
                case 2:
                    $refreshTokenBanco = $this->authModel->usuarioModel->select('refresh_token')->where('id_vendedor', $decodedToken->data->id)->first();

                    if ($refreshToken === $refreshTokenBanco['refresh_token']) {
                        return [
                            'id'           => $decodedToken->data->id,
                            'email'        => $decodedToken->data->email,
                            'refreshToken' => true,
                            'tipoConta'    => 2
                        ];
                    }

                    return [
                        'refreshToken' => false
                    ];
                case 3:
                    $refreshTokenBanco = $this->authModel->lojaModel->select('refresh_token')->where('id_loja', $decodedToken->data->id)->first();

                    if ($refreshToken === $refreshTokenBanco['refresh_token']) {
                        return [
                            'id'           => $decodedToken->data->id,
                            'email'        => $decodedToken->data->email,
                            'refreshToken' => true,
                            'tipoConta'    => 3
                        ];
                    }

                    return [
                        'refreshToken' => false
                    ];
            }
        }

        return false;
    }
}
