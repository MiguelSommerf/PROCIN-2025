<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdutosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produto' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_produto' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => false,
            ],
            'descricao_produto' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'preco_produto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'estoque_produto' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'especificacao_produto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tags_produto' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'marca_produto' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'localidade_produto' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'imagem_produto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'criado_em DATETIME DEFAULT CURRENT_TIMESTAMP',
            'atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id_produto', true);
        $this->forge->createTable('tb_produto', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_produto', true);
    }
}
