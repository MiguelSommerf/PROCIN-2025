<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class ProdutosController extends ResourceController
{
    protected $modelName = 'App\Models\ProdutoModel';
    protected $format    = 'json';

    // Lista todos os produtos
    public function index()
    {
        $produtos = $this->model->findAll();
        return $this->respond($produtos);
    }

    // Cria produto novo
    public function create()
    {
        $file = $this->request->getFile('imagem_produto');

        if (!$file->isValid()) {
            return $this->fail($file->getErrorString(), 400);
        }

        $nomeImagem = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $nomeImagem);

        $produtos = [
            'nome_produto'          => $this->request->getPost('nome_produto'),
            'descricao_produto'     => $this->request->getPost('descricao_produto'),
            'preco_produto'         => $this->request->getPost('preco_produto'),
            'estoque_produto'       => $this->request->getPost('estoque_produto'),
            'especificacao_produto' => $this->request->getPost('especificacao_produto'),
            'tags_produto'          => $this->request->getPost('tags_produto'),
            'marca_produto'         => $this->request->getPost('marca_produto'),
            'localidade_produto'    => $this->request->getPost('localidade_produto'),
            'imagem_produto'        => $nomeImagem
        ];

        if (!$this->model->insert($produtos)) {
            return $this->fail($this->model->errors(), 400);
        }

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Produto cadastrado com sucesso',
            'data'    => $produtos
        ]);
    }

  public function update($id = null)
{
    var_dump($id);
    
    if ($id === null) {
        return $this->fail('ID não informado', 400);
    }

    $produto = $this->model->find($id);
    if (!$produto) {
        return $this->failNotFound('Produto não encontrado');
    }

    // pega dados enviados via form-data
    $data = [
        'nome_produto'          => $this->request->getPost('nome_produto'),
        'descricao_produto'     => $this->request->getPost('descricao_produto'),
        'preco_produto'         => $this->request->getPost('preco_produto'),
        'estoque_produto'       => $this->request->getPost('estoque_produto'),
        'especificacao_produto' => $this->request->getPost('especificacao_produto'),
        'tags_produto'          => $this->request->getPost('tags_produto'),
        'marca_produto'         => $this->request->getPost('marca_produto'),
        'localidade_produto'    => $this->request->getPost('localidade_produto'),
    ];

    // se tiver imagem nova
    $file = $this->request->getFile('imagem_produto');
    if ($file && $file->isValid()) {
        $nomeImagem = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $nomeImagem);

        // remove imagem antiga se existir
        if (!empty($produto['imagem_produto'])) {
            $caminhoImagem = FCPATH . 'uploads/' . $produto['imagem_produto'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        $data['imagem_produto'] = $nomeImagem;
    }

    // remove campos nulos para evitar erro "no data to update"
    $data = array_filter($data, fn($value) => $value !== null && $value !== '');

    if (empty($data)) {
        return $this->fail('Nenhum dado enviado para atualização', 400);
    }

    if (!$this->model->update($id, $data)) {
        return $this->fail($this->model->errors(), 400);
    }

    return $this->respond([
        'status'  => 'success',
        'message' => 'Produto atualizado com sucesso',
        'id'      => $id,
        'data'    => $data
    ]);
}


    // deleta produto
    public function delete($id = null)
    {
        if ($id === null) {
            return $this->fail('ID não informado', 400);
        }

        $produto = $this->model->find($id);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        if (!empty($produto['imagem_produto'])) {
            $caminhoImagem = FCPATH . 'uploads/' . $produto['imagem_produto'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        if (!$this->model->delete($id)) {
            return $this->fail('Erro ao tentar deletar o produto');
        }

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Produto deletado com sucesso',
            'id'      => $id
        ]);
    }
}
