<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pais extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_pais'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nome_pais'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 100
            ]
        ]);
        $this->forge->addKey('id_pais', true);
        $this->forge->createTable('tb_pais');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_pais');
    }
}
