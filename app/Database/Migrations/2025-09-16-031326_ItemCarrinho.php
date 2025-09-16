<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ItemCarrinho extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_item_carrinho'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true
            ],
            'id_carrinho'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
            'id_produto'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
            'quantidade_produto' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
            'preco_produto'      => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
            ]
        ]);
        $this->forge->addKey('id_item_carrinho', true);
        $this->forge->addForeignKey('id_carrinho', 'tb_carrinho', 'id_carrinho');
        $this->forge->addForeignKey('id_produto', 'tb_produto', 'id_produto');
        $this->forge->createTable('tb_item_carrinho');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_item_carrinho');
    }
}
