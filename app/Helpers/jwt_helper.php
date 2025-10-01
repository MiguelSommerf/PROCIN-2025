<?php 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createJWT(array $user): Firebase\JWT\JWT|string
{
    if (empty($user['id']) || empty($user['email'])) {
        throw new InvalidArgumentException('Dados do usuário incompletos');
    }

    $issuedAt = time();
    $expire = $issuedAt + (int)getenv('jwt.expiration');
    $payload = [
        'iss' => getenv('jwt.issuer'),
        'aud' => getenv('jwt.audience'),
        'iat' => $issuedAt,
        'nbf' => $issuedAt - 60,
        'exp' => $expire,
        'sub' => (string)$user['id'],
        'email' => $user['email'],
        'jti' => bin2hex(random_bytes(16))
    ];

    return JWT::encode($payload, getenv('jwt.secret'), 'HS256');
}

function decodeJWT(string $token): Firebase\JWT\JWT|stdClass|string
{
    try {
        return JWT::decode($token, new Key(getenv('jwt.secret'), 'HS256'));
    } catch (Exception $e) {
        return 'Falha ao decodificar o token.';
    }
}
