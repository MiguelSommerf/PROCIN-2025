<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserController extends BaseController
{
    use ResponseTrait;
    
    public function cadastrarUsuario(): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $userModel = new UserModel();
        
        if ($userModel->inserirUsuario($data)) {
            return $this->respondCreated($data);
        }

        return $this->failValidationErrors($userModel->errors());
    }

    public function listarUsuario($id): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $userModel = new UserModel();

        $usuario = $userModel->retornarUsuario($id);

        if ($usuario) {
            return $this->respondCreated($usuario);
        }

        return $this->failValidationErrors($userModel->errors());
    }
}
