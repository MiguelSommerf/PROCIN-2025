<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Vendedor extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_vendedor'         => [
                'type'            => 'INT',
                'constraint'      => 11,
                'unsigned'        => true,
                'auto_increment'  => true
            ],
            'email_vendedor'      => [
                'type'            => 'VARCHAR',
                'constraint'      => 255,
                'unique'          => true
            ],
            'senha_vendedor'      => [
                'type'            => 'VARCHAR',
                'constraint'      => 255
            ],
            'nascimento_vendedor' => [
                'type'            => 'DATE',
                'null'            => false
            ],
            'criado_em'           => [
                'type'            => 'DATETIME',
                'default'         => new RawSql('current_timestamp')
            ],
            'atualizado_em'       => [
                'type'            => 'DATETIME',
                'null'            => true,
                'default'         => null
            ],
            'deletado_em'         => [
                'type'            => 'DATETIME',
                'null'            => true,
                'default'         => null
            ]
        ]);
        $this->forge->addKey('id_vendedor', true);
        $this->forge->createTable('tb_vendedor');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_vendedor');
    }
}
