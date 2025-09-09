<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class ProdutosController extends  ResourceController
{
    protected $modelName = 'App\Models\ProdutoModel'; // define o model
    protected $format = 'json'; // defino que as respostas serao enviadas em json nesse formato

    public function index()
    {
        $produtos = $this->model->findAll(); // busca todos os registros das tabelas produtos
        return $this->respond($produtos);  // retorna em json 
    }

    public function create()
    {
        $file = $this->request->getFile('imagem_produto'); // pega o arquivo enviado


        if(!$file->isValid()){
            return $this->fail($file->getErrorString(), 400); // caso o upload nao funcione retorna erro
        }

        $nomeImagem = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $nomeImagem); // gera um nome aleatorio para evitar conflitos com getrandom e move para a pasta uploads
    

    $produtos = [  // cria um array deles e armazena os enviados 
        'nome_produto'          => $this->request->getPost('nome_produto'),
        'descricao_produto'     => $this->request->getPost('descricao_produto'),
        'preco_produto'         => $this->request->getPost('preco_produto'),
        'estoque_produto'       => $this->request->getPost('estoque_produto'),
        'especificacao_produto' => $this->request->getPost('especificacao_produto'),
        'tags_produto'          => $this->request->getPost('tags_produto'),
        'marca_produto' => $this->request->getPost('marca_produto'),
        'localidade_produto' => $this->request->getPost('localidade_produto'),
        'imagem_produto'        => $nomeImagem // pega os dados via post normal e adiciona imagem

    ];

    if(!$this->model->insert($produtos)){
        return $this->fail($this->model->errors(), 400); // tenta inserir no banco , se der  erro ele manda msg de validacao error 400
    }

    return $this->respondCreated([
    'status'  => 'success',
    'message' => 'Produto cadastrado com sucesso',
    'data'    => $produtos // aqui envia os dados do produto criando o json
    ]);
    }


}