<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    // tabela que esse model usa no banco
    protected $table = 'tb_produto'; 
    
    // chave primária da tabela
    protected $primaryKey = 'id'; 
    
    // id cresce sozinho (auto incremento)
    protected $useAutoIncrement = true;   
    
    // só deixa mexer nos campos que estão em $allowedFields
    protected $protectFields = true; 

    // lista de campos que podem ser inseridos ou atualizados
    protected $allowedFields = [
        'nome_produto',
        'descricao_produto',
        'preco_produto',
        'estoque_produto',
        'especificacao_produto',
        'tags_produto',
        'marca_produto',
        'localidade_produto',
        'imagem_produto'
    ];

    // adiciona automaticamente as datas de criação e atualização
    protected $useTimestamps = true; 
    protected $createdField  = 'criado_em';   
    protected $updatedField  = 'atualizado_em'; 

    // regras de validação pros campos antes de salvar
    protected $validationRules = [
        'nome_produto'          => 'required|min_length[3]|max_length[150]',
        'preco_produto'         => 'required|decimal',
        'estoque_produto'       => 'required|integer',
        'especificacao_produto' => 'required|min_length[16]|max_length[300]',
        'localidade_produto'    => 'required'
    ];

    // mensagens de erro personalizadas caso as regras não sejam seguidas
    protected $validationMessages = [
        'nome_produto' => [
            'required'   => 'O nome do produto é obrigatório',
            'min_length' => 'O nome precisa ter pelo menos 3 caracteres'
        ],
        'preco_produto' => [
            'required' => 'O preço é obrigatório',
            'decimal'  => 'O preço deve estar em formato decimal'
        ],
        'estoque_produto' => [
            'required' => 'O estoque é obrigatório',
            'integer'  => 'O estoque precisa ser um número inteiro'
        ],
        'especificacao_produto' => [
            'required'   => 'A especificação do produto é obrigatória',
            'min_length' => 'Escreva mais detalhes na especificação'
        ],
        'localidade_produto' => [
            'required' => 'A localidade do produto é obrigatória'
        ]
    ];

    // insere um novo produto no banco, já cuidando da imagem se tiver
    public function inserirProduto(array $dados, $file = null): bool
    {
        if ($file && $file->isValid()) {
            $nomeImagem = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $nomeImagem);
            $dados['imagem_produto'] = $nomeImagem;
        }

        return $this->insert($dados) !== false;
    }

    // atualiza um produto que já existe, trocando a imagem se for enviada uma nova
    public function atualizarProduto(int $id, array $dados, $file = null): bool
    {
        $produto = $this->find($id);
        if (!$produto) return false;

        if ($file && $file->isValid()) {
            $nomeImagem = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $nomeImagem);

            // apaga a imagem antiga, se existir
            if (!empty($produto['imagem_produto'])) {
                $caminho = FCPATH . 'uploads/' . $produto['imagem_produto'];
                if (file_exists($caminho)) unlink($caminho);
            }

            $dados['imagem_produto'] = $nomeImagem;
        }

        // remove valores nulos ou vazios pra não dar erro no update
        $dados = array_filter($dados, fn($v) => $v !== null && $v !== '');
        if (empty($dados)) return false;

        return $this->update($id, $dados);
    }

    // deleta um produto e apaga a imagem associada, se existir
    public function deletarProduto(int $id): bool
    {
        $produto = $this->find($id);
        if (!$produto) return false;

        if (!empty($produto['imagem_produto'])) {
            $caminho = FCPATH . 'uploads/' . $produto['imagem_produto'];
            if (file_exists($caminho)) unlink($caminho);
        }

        return $this->delete($id);
    }
}
