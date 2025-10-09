<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VendedorModel;

class VendedorController extends BaseController
{
    protected $vendedorModel;

    public function __construct()
    {
        $this->vendedorModel = new VendedorModel();
    }

    public function cadastrarVendedor(array $request): bool
    {
        if ($this->vendedorModel->inserirVendedor($request)) {
            return true;
        }

        return false;
    }

    public function atualizarVendedor($idVendedor, $campos, $dados): bool
    {
        if ($this->vendedorModel->atualizarVendedor($idVendedor, $campos, $dados)) {
            return true;
        }

        return false;
    }

    public function retornarVendedor(string $emailVendedor): array|bool
    {
        $dadosVendedor = $this->vendedorModel->retornarDadosVendedor($emailVendedor);

        if (!empty($dadosVendedor)) {
            return $dadosVendedor;
        }

        return false;
    }
}
