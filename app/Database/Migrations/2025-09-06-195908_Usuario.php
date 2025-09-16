<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Usuario extends Migration
{
    public function up(): void
    {
        //forge-> molda a tabela
        $this->forge->addField([
            'id_usuario'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_usuario'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'email_usuario'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'unique'         => true,
                'null'           => false,
            ],
            'senha_usuario'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'nascimento_usuario' => [
                'type'           => 'DATE',
                'null'           => false,
            ],
            'criado_em'          => [
                'type'           => 'DATETIME',
                'null'           => false,
                'default'        => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'atualizado_em'      => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],
            'deletado_em'        => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ]
            ]);
        $this->forge->addKey('id_usuario', true);
        $this->forge->createTable('tb_usuario');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_usuario');
    }
}
