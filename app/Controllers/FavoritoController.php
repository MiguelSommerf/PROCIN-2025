<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FavoritoModel;
use App\Models\ProdutosModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class FavoritoController extends BaseController
{
    use ResponseTrait;

    public function favorito(): ResponseInterface
    {
        $request = $this->request->getJSON(true);
        $favorito = new FavoritoModel();

        if ($favorito->adicionarFavorito($request['id_usuario'], $request['id_produto'])) {
            return $this->respondCreated(true);
        }

        return $this->failValidationErrors('Produto já favoritado.');
    }

    public function remover(): ResponseInterface
    {
        $request = $this->request->getJSON(true);
        $favorito = new FavoritoModel();

        if ($favorito->removerFavorito($request['id_usuario'], $request['id_produto'])) {
            return $this->respondDeleted(true);
        }

        return $this->failNotFound('Favorito não encontrado.');
    }

    public function listar($idUsuario): ResponseInterface
    {
        $favorito = new FavoritoModel();
        $dados = $favorito->listarFavoritos($idUsuario);

        return $this->respond($dados);
    }
}
