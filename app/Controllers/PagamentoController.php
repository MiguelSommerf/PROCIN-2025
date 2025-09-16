<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\PagamentoModel;

class PagamentoController extends BaseController
{
    use ResponseTrait;

    public function gerarTransacao($idProduto): ResponseInterface
    {
        // Aqui vai o select do produto, mas ainda não tem essa função no Controller/Model de Produtos
        $dadosProduto = null;

        $pagamentoModel = new PagamentoModel();
        $preference = $pagamentoModel->gerarPreference($dadosProduto);

        if ($preference) {
            return $this->respondCreated('Pagamento efetuado com sucesso!');
        }
        
        return $this->failValidationErrors($pagamentoModel->errors());
    }
}
