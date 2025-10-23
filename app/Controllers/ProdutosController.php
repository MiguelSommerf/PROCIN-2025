<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProdutosController extends ResourceController
{
    use ResponseTrait;
    
    protected $modelName = 'App\Models\ProdutoModel';
    protected $format    = 'json';

    // listar todos os produtos
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // criar o produto
    public function create()
    {
        $dados = $this->request->getPost();
        $file  = $this->request->getFile('imagem_produto');

        if (!$this->model->inserirProduto($dados, $file)) {
            return $this->fail($this->model->errors(), 400);
        }

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Produto cadastrado com sucesso',
            'data'    => $dados
        ]);
    }

    // atualizar o produto
    public function update($id = null)
    {
        if ($id === null) return $this->fail('ID não informado', 400);

        $dados = $this->request->getPost();
        $file  = $this->request->getFile('imagem_produto');

        if (!$this->model->atualizarProduto($id, $dados, $file)) {
            return $this->fail($this->model->errors() ?: 'Erro ao atualizar', 400);
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Produto atualizado com sucesso',
            'id'      => $id,
            'data'    => $dados
        ]);
    }

    public function selecionarProduto($idProduto): array|ResponseInterface
    {
        $produtoModel = new ProdutoModel();
        $produto = $produtoModel->encontrarProduto($idProduto);

        if ($produto) {
            return $produto;
        }

        return $this->respond(['mensagem' => 'Produto não encontrado.']);
    }

    // deletar o produto
    public function delete($id = null)
    {
        if ($id === null) return $this->fail('ID não informado', 400);

        if (!$this->model->deletarProduto($id)) {
            return $this->fail('Erro ao deletar produto', 400);
        }

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Produto deletado com sucesso',
            'id'      => $id
        ]);
    }
}
//