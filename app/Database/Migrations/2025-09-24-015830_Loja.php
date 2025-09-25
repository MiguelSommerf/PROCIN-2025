<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Loja extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_loja'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'email_loja'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'unique'         => true
            ],
            'senha_loja'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ],
            'nome_loja'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ],
            'especialidade_loja' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ],
            'criado_em'          => [
                'type'           => 'DATETIME',
                'default'        => new RawSql('current_timestamp')
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
        $this->forge->addKey('id_loja', true);
        $this->forge->createTable('tb_loja');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_loja');
    }
}
