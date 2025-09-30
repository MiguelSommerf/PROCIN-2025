<?php

namespace App\Controllers;

use App\Models\VendedorProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class VendedorProdutoController extends ResourceController
{
    protected $model;

    public function __construct()
    {
        $this->model = new VendedorProdutoModel();
    }

    // aqui adiciono produto e atribuo pra usuario
    public function atribuirProduto()
    {
        $request = $this->request->getJSON(true);

        $idUsuario = !empty($request['id_usuario']) ? $request['id_usuario'] : null;
        $idProduto = !empty($request['id_produto']) ? $request['id_produto'] : null;

        if (!$idUsuario || !$idProduto) {
            return $this->failValidationErrors('id_usuario e id_produto são obrigatórios.');
        }

        if ($this->model->existeVinculo($idUsuario, $idProduto)) {
            return $this->failResourceExists('Produto já atribuído a esse usuário.');
        }

        $this->model->insert([
            'id_usuario' => $idUsuario,
            'id_produto' => $idProduto,
        ]);

        return $this->respondCreated(['message' => 'Produto atribuído com sucesso.']);
    }

    //listo eles
    public function listarProdutos($idUsuario = null)
    {
        if (!$idUsuario) {
            return $this->failValidationErrors('Informe o id_usuario.');
        }

        $produtos = $this->model->listarProdutosDoUsuario($idUsuario);

        return $this->respond($produtos);
    }

    // remover produito normal
    public function removerProduto()
    {
        $idUsuario = $this->request->getPost('id_usuario');
        $idProduto = $this->request->getPost('id_produto');

        if (!$idUsuario || !$idProduto) {
            return $this->failValidationErrors('id_usuario e id_produto são obrigatórios.');
        }

        $this->model->removerVinculo($idUsuario, $idProduto);

        return $this->respondDeleted(['message' => 'Produto removido com sucesso.']);
    }
}
