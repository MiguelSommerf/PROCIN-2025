<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'tb_produto'; // qual tabela vai ser manipulada
    protected $primaryKey = 'id_produto'; // definindo a chave primaria da tabela
    protected $useAutoIncrement = true;   // indica que auto incremento aqui nessa linha (o banco gera o propximo numero ao adicionar algum produto)
    protected $protectFields = true; // aqui indica que só os campos listados com allowdFields podem ser manipulados

    protected $allowedFields = ['nome_produto', 'descricao_produto', 'preco_produto', 'estoque_produto', 'especificacao_produto', 'tags_produto', 'marca_produto', 'localidade_produto','imagem_produto'];
     // aqui os campos serao manipulados pelo model

    protected $useTimestamps = true; // usado para colocar quando foi criado, automaticamente sem precisar de nenhum campo
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em'; 

    protected $validationRules = [
        'nome_produto' => 'required|min_length[3]|max_length[150]',
        'preco_produto' => 'required|decimal',
        'estoque_produto' => 'required|integer',
        'especificacao_produto' => 'required|min_length[16]|max_length[300]',
        // 'tags_produto' => sem regra
        //'marca_produto' => sem regra
        'localidade_produto' => 'required'

    ]; // regras de validação pra cada campo no bloco acima

    // validations usado pra regras nos campos, abaixo configurei para dar os "echos"  quando cair nessa situação
    protected $validationMessages = [
        'nome_produto' => [
            'required' => 'o nome do produto é obrigatório',
            'min_length' => 'o nome deve ter no minimo 3 caracteres'
        ],

        'preco_produto' => [
            'required' => 'o preco é obrigatorio',
            'decimal' => 'o preco precisa ser numero decimal'
        ],

        'estoque_produto' => [
            'required' => 'obrigatorio o estoque',
            'integer' => 'tem que ser numero inteiro'
        ],

        'especificacao_produto' => [
            'required' => 'você precisa especificar melhor seu produto ( cor, tamanho etc..)',
            'min_length' => 'escreva mais na especificacao'
        ],

        'localidade_produto' => [
            'required' => 'você precisa especificar melhor seu produto ( cor, tamanho etc..)'
        ],

    ];

    public function inserirProduto(array $produto) : bool // array $produto exige que o valor passado seja um array com os valores
    {
        if(!empty($produto)){ // se tiver vazio ja retorna falso no final isso 
            $produto['nome_produto'] = trim(ucfirst($produto['nome_produto'])); // trim (tira espacos sobrando e ucFirst deixa a primeira sempre maiuscula
            $produto['preco_produto'] = (float) $produto['preco_produto']; // define float para moeda no preco
            $produto['estoque_produto'] = (int) $produto['estoque_produto'];

            return $this->insert($produto); // chamei o metodo para inserir, se der certo da bom
        }

        return false;
    }
} 