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

        return redirect()->to($authUrl);
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

        $userData = [
            'nome_usuario' => $googleUser->name,
            'email_usuario' => $googleUser->email,
            'senha_usuario' => null,
            'nascimento_usuario' => null,
        ];

        $userModel = new UserModel();
        $user = $userModel->where('email_usuario', $googleUser->email)->first();

        if (!$user) {
            $userModel->inserirUsuario($userData);
            $user = $userModel->where('email_usuario', $googleUser->email)->first();

            helper('jwt');

            $jwt = createJWT([
                'id'    => $user['id_usuario'],
                'email' => $user['email_usuario'],
            ]);

            return $this->respond([
                'success' => true,
                'jwt'     => $jwt,
                'user'    => $user,
                'login'   => false
            ]);
        }

        helper('jwt');

        $jwt = createJWT([
            'id'    => $user['id_usuario'],
            'email' => $user['email_usuario'],
        ]);

        return $this->respond([
            'success' => true,
            'jwt'     => $jwt,
            'user'    => $user,
            'login'   => true
        ]);
    }
}
