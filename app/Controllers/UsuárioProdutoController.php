<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use App\Models\UsuarioProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class UsuarioProdutoController extends ResourceController
{
    protected $usuarioProdutoModel;

    public function __construct()
    {
        $this->usuarioProdutoModel = new UsuarioProdutoModel();
    }

    
    public function atribuirProduto()
    {
        $data = $this->request->getPost(); 
        if (!isset($data['id_usuario']) || !isset($data['id_produto'])) {
            return $this->fail('id_usuario e id_produto são obrigatórios', 400);
        }

        
        $existente = $this->usuarioProdutoModel
            ->where('id_usuario', $data['id_usuario'])
            ->where('id_produto', $data['id_produto'])
            ->first();

        if ($existente) {
            return $this->fail('Produto já atribuído a esse usuário', 409);
        }

        $this->usuarioProdutoModel->insert($data);
        return $this->respondCreated(['message' => 'Produto atribuído com sucesso']);
    }

    
    public function listarProdutos($id_usuario)
    {
        $produtos = $this->usuarioProdutoModel
            ->select('tb_produto.*')
            ->join('tb_produto', 'tb_produto.id = tb_usuario_produto.id_produto')
            ->where('tb_usuario_produto.id_usuario', $id_usuario)
            ->findAll();

        return $this->respond($produtos);
    }

    
    public function removerProduto()
    {
        $data = $this->request->getPost(); 

        if (!isset($data['id_usuario']) || !isset($data['id_produto'])) {
            return $this->fail('id_usuario e id_produto são obrigatórios', 400);
        }

        $this->usuarioProdutoModel
            ->where('id_usuario', $data['id_usuario'])
            ->where('id_produto', $data['id_produto'])
            ->delete();

        return $this->respondDeleted(['message' => 'Produto removido com sucesso']);
    }
}
