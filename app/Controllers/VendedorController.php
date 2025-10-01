<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VendedorModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class VendedorController extends BaseController
{
    use ResponseTrait;

    public function cadastrarVendedor(array $request): bool
    {
        $vendedorModel = new VendedorModel();

        if ($vendedorModel->inserirVendedor($request)) {
            return true;
        }

        return false;
    }

    public function retornarVendedor(string $emailVendedor): array|bool
    {
        $vendedorModel = new VendedorModel();
        $dadosVendedor = $vendedorModel->retornarDadosVendedor($emailVendedor);

        if (!empty($dadosVendedor)) {
            return $dadosVendedor;
        }

        return false;
    }
}
