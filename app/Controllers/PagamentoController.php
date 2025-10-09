<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\PagamentoModel;

class PagamentoController extends BaseController
{
    use ResponseTrait;

    public function gerarTransacao($idProduto): ResponseInterface
    {
        $session = session();

        $usuarioController = new UsuarioController();
        $idUsuario = $session()->get('id_usuario');
        $dadosUsuario = $usuarioController->retornarDadosUsuario($idUsuario);

        // Preciso criar o cadastro de vendedor e model de vendedor
        $vendedorModel = null;
        $dadosVendedor = null;

        $produtoController = new ProdutosController();
        $dadosProduto = $produtoController->selecionarProduto($idProduto);

        $pagamentoModel = new PagamentoModel();
        $preference = $pagamentoModel->gerarPreference($dadosUsuario['pais_usuario'], $dadosVendedor, $dadosProduto, $dadosUsuario);

        if ($preference) {
            return $this->respondCreated('Pagamento efetuado com sucesso!');
        }
        
        return $this->failValidationErrors($pagamentoModel->errors());
    }
}
