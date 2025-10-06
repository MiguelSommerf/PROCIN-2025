<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Favorito extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_favorito' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'id_produto' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ]
        ]);

        $this->forge->addKey('id_favorito', true);
        $this->forge->addForeignKey('id_usuario', 'tb_usuario', 'id_usuario');
        $this->forge->addForeignKey('id_produto', 'tb_produto', 'id_produto');
        $this->forge->createTable('tb_favorito');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_favorito');
    }
}
