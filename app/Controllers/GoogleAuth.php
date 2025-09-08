<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use Google\Client as GoogleClient;
use App\Models\UserModel;

class GoogleAuth extends ResourceController
{
    private function getGoogleClient(): GoogleClient
    {
        $client = new GoogleClient();
        $client->setClientId(getenv('google.client_id'));
        $client->setClientSecret(getenv('google.client_secret'));
        $client->setRedirectUri(getenv('google.redirect_uri'));
        $client->addScope('email');
        $client->addScope('profile');

        return $client;
    }

    public function googleUrl(): ResponseInterface
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();

        return $this->respond(['url' => $authUrl]);
    }

    public function googleCallback(): ResponseInterface
    {
        $code = $this->request->getGet('code');
        
        if (!$code) {
            return $this->fail('Código não fornecido');
        }

        $client = $this->getGoogleClient();
        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            return $this->fail('Erro ao autenticar com o Google');
        }

        $client->setAccessToken($token['access_token']);
        $googleService = new \Google\Service\OAuth2($client);
        $googleUser = $googleService->userinfo->get();

        $userModel = new UserModel();
        $user = $userModel->where('email_usuario', $googleUser->email)->first();

        if (!$user) {
            $userData = [
                'nome_usuario' => $googleUser->name,
                'email_usuario' => $googleUser->email,
                'senha_usuario' => null,
                'nascimento_usuario' => '0000-00-00',
            ];

            $userModel->insert($userData);
            $user = $userModel->where('email_usuario', $googleUser->email)->first();
        }

        $jwt = createJWT([
            'id'    => $user['id_usuario'],
            'email' => $user['email_usuario'],
        ]);

        return $this->respond([
            'user'  => $user,
            'token' => $jwt,
        ]);
    }
}
