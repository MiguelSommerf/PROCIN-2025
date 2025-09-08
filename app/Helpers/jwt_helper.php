<?php 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createJWT($user): Firebase\JWT\JWT|string
{
    $issuedAt = time();
    $expire = $issuedAt + getenv('jwt.expiration');
    $payload = [
        'iss' => getenv('jwt.issuer'),
        'aud' => getenv('jwt.audience'),
        'iat' => $issuedAt,
        'exp' => $expire,
        'sub' => $user['id_usuario'],
        'email' => $user['email_usuario'],
    ];

    return JWT::encode($payload, getenv('jwt.secret'), 'HS256');
}

function decodeJWT($token): Firebase\JWT\JWT|stdClass|string
{
    try {
        return JWT::decode($token, new Key(getenv('jwt.secret'), 'HS256'));
    } catch (Exception $e) {
        return 'Falha ao decodificar o token.';
    }
}
