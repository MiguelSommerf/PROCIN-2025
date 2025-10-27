<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    public function index(): ResponseInterface
    {
        return $this->response->setJSON([
            'status' => 200,
            'mensagem' => 'Soma - API Restful'
        ]);
    }

    public function notFound(): ResponseInterface
    {
        return $this->response->setJSON([
            'status'   => 404,
            'mensagem' => 'Rota não encontrada.'
        ]);
    }
}
