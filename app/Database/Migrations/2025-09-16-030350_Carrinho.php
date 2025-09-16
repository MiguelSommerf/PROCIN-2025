<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Carrinho extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_carrinho'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_usuario'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false
            ],
            'criado_em'          => [
                'type'           => 'DATETIME',
                'default'        => new RawSql('CURRENT_TIMESTAMP'),
                'null'           => false
            ],
            'atualizado_em'      => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null
            ],
            'deletado_em'        => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null
            ]
        ]);

        $this->forge->addKey('id_carrinho', true);
        $this->forge->addForeignKey('id_usuario', 'tb_usuario', 'id_usuario');
        $this->forge->createTable('tb_carrinho');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_carrinho');
    }
}
