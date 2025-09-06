<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Produto extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_produto'        => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
            ],
            'nome_produto'      => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'descricao_produto' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'postado_em'        => [
                'type'          => 'DATETIME',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'atualizado_em'     => [
                'type'          => 'DATETIME',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
                'null'          => true,
            ],
            'deletado_em'       => [
                'type'          => 'DATETIME',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
                'null'          => true,
            ],
            'preco_produto'     => [
                'type'          => 'DECIMAL',
                'constraint'    => '10,2',
            ],
        ]);
        $this->forge->addKey('id_produto', true);
        $this->forge->createTable('tb_produto');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_produto');
    }
}
